<?php

namespace App\Livewire\Admin;

use App\Models\CashCollection;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CashCollectionManager extends Component
{
    public string $customer_name = '';

    public ?string $amount = null;

    public string $received_at = '';

    public string $notes = '';

    public function mount(): void
    {
        $this->received_at = now()->toDateString();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'received_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        CashCollection::create($validated);

        $this->reset(['customer_name', 'amount', 'notes']);
        $this->received_at = now()->toDateString();
        session()->flash('message', 'Malipo ya COD yamehifadhiwa.');
    }

    public function render(): View
    {
        $collections = CashCollection::query()->latest('received_at')->latest()->get();

        return view('livewire.admin.cash-collection-manager', [
            'collections' => $collections,
            'totalCollected' => $collections->sum('amount'),
            'todayCollected' => $collections->where('received_at', today())->sum('amount'),
        ]);
    }
}
