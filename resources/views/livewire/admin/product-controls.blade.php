<div class="mb-6 space-y-3">
    <div>
        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-[#a85335]">Usimamizi wa bidhaa</p>
    </div>
    <div class="flex flex-col gap-3 rounded-2xl border border-[#25251f]/10 bg-white p-4 sm:flex-row sm:items-end">
        <div class="min-w-0 flex-1">
            <label class="mb-1.5 block text-xs font-bold" for="product-search">Tafuta bidhaa</label>
            <input id="product-search" class="admin-product-input w-full rounded-xl border px-3.5 py-3 text-sm" type="search" wire:model.live.debounce.300ms="search" placeholder="Jina, kategoria au maelezo..." aria-describedby="product-search-help">
            <p id="product-search-help" class="mt-1 text-[11px] text-[#777269]">Matokeo hubadilika unapoandika.</p>
        </div>
        <div class="sm:w-48">
            <label class="mb-1.5 block text-xs font-bold" for="stock-filter">Hali ya stock</label>
            <select id="stock-filter" class="admin-product-input w-full rounded-xl border px-3 py-3 text-sm" wire:model.live="stockFilter">
                <option value="all">Zote</option>
                <option value="in_stock">Zinapatikana</option>
                <option value="out_of_stock">Hazipatikani</option>
            </select>
        </div>
        <div wire:loading wire:target="search,stockFilter" class="flex items-center gap-2 pb-3 text-xs font-semibold text-[#a85335]" role="status" aria-live="polite">
            <span class="size-2 animate-pulse rounded-full bg-[#a85335]" aria-hidden="true"></span>
            Inatafuta...
        </div>
    </div>

    @if ($confirmingDeleteId)
        @php($productToDelete = $products->firstWhere('id', $confirmingDeleteId))
        <div class="flex flex-col gap-3 rounded-xl border border-red-700/20 bg-red-50 px-4 py-3 text-sm text-red-900 sm:flex-row sm:items-center sm:justify-between" role="alert" aria-live="assertive">
            <p>
                <strong>Thibitisha kufuta.</strong>
                {{ $productToDelete?->name ?? 'Bidhaa hii' }} itaondolewa kabisa.
            </p>
            <div class="flex shrink-0 gap-2">
                <button class="rounded-lg border border-red-700/20 bg-white px-3 py-2 text-xs font-bold" type="button" wire:click="cancelDelete">Ghairi</button>
                <button class="rounded-lg bg-red-700 px-3 py-2 text-xs font-bold text-white" type="button" wire:click="deleteConfirmed" wire:loading.attr="disabled" wire:target="deleteConfirmed">Futa bidhaa</button>
            </div>
        </div>
    @endif

    <div wire:loading wire:target="save,deleteConfirmed" class="text-xs font-semibold text-[#a85335]" role="status" aria-live="polite">
        Inahifadhi mabadiliko...
    </div>
</div>
