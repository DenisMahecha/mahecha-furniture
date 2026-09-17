<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductManager extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $category = '';

    public ?string $price = null;

    public string $description = '';

    public $image;

    public bool $in_stock = true;

    public ?int $editingId = null;

    public string $search = '';

    public string $stockFilter = 'all';

    public ?int $confirmingDeleteId = null;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['Viti', 'Meza', 'Vitanda', 'Makabati'])],
            'price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:2048'],
            'in_stock' => ['boolean'],
        ]);

        $product = $this->editingId ? Product::findOrFail($this->editingId) : new Product;
        $product->fill(collect($validated)->except('image')->all());

        if ($this->image) {
            if ($product->image_path && ! str_starts_with($product->image_path, 'http')) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->image_path = $this->image->store('products', 'public');
        }

        $product->save();

        $this->resetForm();
        session()->flash('message', 'Bidhaa imehifadhiwa kikamilifu.');
    }

    public function edit(Product $product): void
    {
        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->category = $product->category;
        $this->price = $product->price === null ? null : (string) $product->price;
        $this->description = $product->description ?? '';
        $this->in_stock = $product->in_stock;
        $this->resetValidation();
    }

    public function confirmDelete(int $productId): void
    {
        $this->confirmingDeleteId = $productId;
    }

    public function delete(Product $product): void
    {
        $this->confirmDelete($product->id);
    }

    public function deleteConfirmed(): void
    {
        if (! $this->confirmingDeleteId) {
            return;
        }

        $product = Product::findOrFail($this->confirmingDeleteId);

        if ($product->image_path && ! str_starts_with($product->image_path, 'http')) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();
        $this->confirmingDeleteId = null;
        session()->flash('message', 'Bidhaa imefutwa.');
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function render(): View
    {
        $products = Product::query()
            ->when($this->search !== '', function ($query): void {
                $search = '%'.$this->search.'%';

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', $search)
                        ->orWhere('category', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->stockFilter !== 'all', fn ($query) => $query->where('in_stock', $this->stockFilter === 'in_stock'))
            ->latest()
            ->get();

        return view('livewire.admin.product-manager', [
            'products' => $products,
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['name', 'category', 'price', 'description', 'image', 'editingId']);
        $this->in_stock = true;
        $this->resetValidation();
    }
}
