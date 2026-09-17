<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductCatalog extends Component
{
    public string $search = '';

    public string $category = 'Zote';

    public function render(): View
    {
        return view('livewire.product-catalog', [
            'products' => $this->catalogProducts(),
            'categories' => Product::query()
                ->where('in_stock', true)
                ->whereNotNull('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
        ]);
    }

    private function catalogProducts(): Collection
    {
        $categoryDetails = [
            'Viti' => ['eyebrow' => 'Kukaa kwa starehe', 'accent' => 'ochre', 'image' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?auto=format&fit=crop&w=900&q=85'],
            'Meza' => ['eyebrow' => 'Moyo wa nyumba', 'accent' => 'clay', 'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=900&q=85'],
            'Vitanda' => ['eyebrow' => 'Pumzika vizuri', 'accent' => 'sage', 'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=85'],
            'Makabati' => ['eyebrow' => 'Nafasi yenye mpangilio', 'accent' => 'ink', 'image' => 'https://images.unsplash.com/photo-1558997519-83ea9252edf8?auto=format&fit=crop&w=900&q=85'],
        ];

        return Product::query()
            ->where('in_stock', true)
            ->when($this->search !== '', function ($query): void {
                $search = '%'.$this->search.'%';

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', $search)
                        ->orWhere('description', 'like', $search)
                        ->orWhere('category', 'like', $search);
                });
            })
            ->when($this->category !== 'Zote', fn ($query) => $query->where('category', $this->category))
            ->latest()
            ->get()
            ->map(function (Product $product) use ($categoryDetails): array {
                $details = $categoryDetails[$product->category] ?? $categoryDetails['Viti'];

                return [
                    'name' => $product->name,
                    'eyebrow' => $details['eyebrow'],
                    'description' => $product->description ?? 'Fenicha iliyotengenezwa kwa ustadi na vifaa vinavyodumu.',
                    'image' => $product->imageUrl() ?? $details['image'],
                    'accent' => $details['accent'],
                    'price' => $product->price,
                    'whatsappLink' => $product->whatsappLink(),
                ];
            });
    }
}
