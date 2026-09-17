<div class="admin-cash-page flex w-full flex-1 flex-col gap-8">
    <header class="flex flex-wrap items-end justify-between gap-5">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Mahecha Furniture / Finance</p>
            <flux:heading size="xl" class="mt-2">Cash on delivery</flux:heading>
            <flux:subheading class="mt-1">Rekodi hela iliyopokelewa baada ya mteja kupokea bidhaa.</flux:subheading>
        </div>
        <flux:button variant="ghost" icon="archive-box" href="{{ route('admin.products') }}" wire:navigate>Bidhaa</flux:button>
    </header>

    @if (session('message'))
        <div class="rounded-xl border border-emerald-700/20 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('message') }}</div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Jumla iliyopokelewa</p><p class="mt-3 text-3xl font-semibold text-[#a85335]">TZS {{ number_format((float) $totalCollected) }}</p><p class="mt-1 text-xs text-zinc-500">Rekodi zote za COD</p></div>
        <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Leo</p><p class="mt-3 text-3xl font-semibold text-emerald-700">TZS {{ number_format((float) $todayCollected) }}</p><p class="mt-1 text-xs text-zinc-500">Malipo yaliyopokelewa leo</p></div>
    </div>

    <div class="grid items-start gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">
        <section class="admin-collection-form rounded-2xl border border-[#25251f]/10 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6"><p class="text-[10px] font-bold uppercase tracking-[.17em] text-[#a85335]">Rekodi mpya ya malipo</p><flux:heading size="lg" class="mt-1">Rekodi malipo</flux:heading><p class="mt-2 text-sm text-[#625d54]">Jaza taarifa hizi baada ya oda ya mteja kukabidhiwa.</p></div>
            <form class="space-y-4" wire:submit="save">
                <div><label class="mb-1.5 block text-xs font-bold" for="customer-name">Jina la mteja</label><input id="customer-name" class="admin-product-input w-full rounded-xl border px-3.5 py-3 text-sm" type="text" wire:model="customer_name" placeholder="Mfano: Amina Juma" required>@error('customer_name')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                <div><label class="mb-1.5 block text-xs font-bold" for="amount">Kiasi kilichopokelewa (TZS)</label><input id="amount" class="admin-product-input w-full rounded-xl border px-3.5 py-3 text-sm" type="number" min="0.01" step="0.01" wire:model="amount" placeholder="0" required>@error('amount')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                <div><label class="mb-1.5 block text-xs font-bold" for="received-at">Tarehe ya kupokea</label><input id="received-at" class="admin-product-input w-full rounded-xl border px-3.5 py-3 text-sm" type="date" wire:model="received_at" required>@error('received_at')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                <div><label class="mb-1.5 block text-xs font-bold" for="collection-notes">Maelezo</label><textarea id="collection-notes" class="admin-product-input min-h-24 w-full rounded-xl border px-3.5 py-3 text-sm" wire:model="notes" placeholder="Maelezo ya ziada..."></textarea>@error('notes')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                <button class="w-full rounded-xl bg-[#a85335] px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-[#25251f]" type="submit" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save">Hifadhi malipo</span><span wire:loading wire:target="save">Inahifadhi...</span></button>
            </form>
        </section>

        <section class="admin-data-table overflow-hidden rounded-2xl border border-[#25251f]/10 bg-[#fcfaf6] shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#25251f]/10 px-6 py-5"><div><p class="text-[10px] font-bold uppercase tracking-[.17em] text-[#a85335]">Payment log</p><flux:heading size="lg" class="mt-1">Malipo yaliyopokelewa</flux:heading></div><span class="text-sm text-zinc-500">{{ $collections->count() }} records</span></div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($collections as $collection)
                    <article class="flex flex-wrap items-center justify-between gap-4 border-l-4 border-[#d2a24b] px-6 py-5"><div class="min-w-0"><h3 class="truncate font-semibold">{{ $collection->customer_name }}</h3><p class="mt-1 text-xs text-zinc-500">{{ $collection->received_at->format('d/m/Y') }}</p>@if ($collection->notes)<p class="mt-1 text-xs text-zinc-500">{{ $collection->notes }}</p>@endif</div><p class="font-semibold text-[#a85335]">TZS {{ number_format((float) $collection->amount) }}</p></article>
                @empty
                    <div class="px-6 py-16 text-center"><flux:icon name="banknotes" class="mx-auto size-8 text-[#a85335]" /><p class="mt-3 font-semibold">Hakuna malipo yaliyorekodiwa</p><p class="mt-1 text-sm text-zinc-500">Tumia form upande wa kushoto kuanza.</p></div>
                @endforelse
            </div>
        </section>
    </div>
</div>