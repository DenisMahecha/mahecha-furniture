<x-layouts.app>
    <div class="admin-dashboard flex w-full flex-1 flex-col gap-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Mahecha Furniture</p>
                <flux:heading size="xl" class="mt-2">Dashboard ya admin</flux:heading>
                <flux:subheading class="mt-1">Dhibiti catalog ya bidhaa na uone hali ya biashara yako kwa haraka.</flux:subheading>
            </div>
            <flux:button variant="primary" icon="plus" href="{{ route('admin.products') }}" wire:navigate class="!bg-[#a85335] !text-white hover:!bg-[#25251f]">Ongeza bidhaa</flux:button>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><div class="flex items-center justify-between"><span class="text-sm text-zinc-500">Bidhaa zote</span><flux:icon name="archive-box" class="size-5 text-[#a85335]" /></div><p class="mt-4 text-3xl font-semibold">{{ $totalProducts }}</p><p class="mt-1 text-xs text-zinc-500">Kwenye catalog</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><div class="flex items-center justify-between"><span class="text-sm text-zinc-500">Zinapatikana</span><flux:icon name="check-circle" class="size-5 text-emerald-600" /></div><p class="mt-4 text-3xl font-semibold">{{ $availableProducts }}</p><p class="mt-1 text-xs text-zinc-500">Zinaonekana website</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><div class="flex items-center justify-between"><span class="text-sm text-zinc-500">Hazipatikani</span><flux:icon name="pause-circle" class="size-5 text-amber-600" /></div><p class="mt-4 text-3xl font-semibold">{{ $unavailableProducts }}</p><p class="mt-1 text-xs text-zinc-500">Zimefichwa website</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><div class="flex items-center justify-between"><span class="text-sm text-zinc-500">Kategoria</span><flux:icon name="squares-2x2" class="size-5 text-[#a85335]" /></div><p class="mt-4 text-3xl font-semibold">{{ $categoryCount }}</p><p class="mt-1 text-xs text-zinc-500">Aina za bidhaa</p></div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
            <section class="admin-table-card rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Hali ya catalog</p>
                        <flux:heading size="lg" class="mt-2">Inventory health</flux:heading>
                        <flux:subheading class="mt-1">Bidhaa zinazoonekana kwa wateja kwa sasa.</flux:subheading>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">{{ $stockRate }}% active</span>
                </div>
                <div class="mt-6 h-3 overflow-hidden rounded-full bg-[#e7ded0]" style="--health-progress: {{ $stockRate }}%" aria-label="{{ $stockRate }}% ya bidhaa zinapatikana">
                    <div class="admin-health-bar h-full rounded-full" style="width: {{ $stockRate }}%"></div>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div><p class="text-xs text-zinc-500">Zinaonekana</p><p class="mt-1 text-xl font-semibold text-emerald-700">{{ $availableProducts }}</p></div>
                    <div><p class="text-xs text-zinc-500">Zimefichwa</p><p class="mt-1 text-xl font-semibold text-amber-700">{{ $unavailableProducts }}</p></div>
                    <div><p class="text-xs text-zinc-500">Bila bei</p><p class="mt-1 text-xl font-semibold text-[#a85335]">{{ $missingPriceCount }}</p></div>
                </div>
            </section>

            <section class="admin-table-card rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between gap-3">
                    <div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Mix ya catalog</p><flux:heading size="lg" class="mt-2">Kwa category</flux:heading></div>
                    <flux:icon name="chart-bar" class="size-5 text-[#a85335]" />
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($categoryBreakdown as $category => $count)
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-xs"><span class="font-semibold">{{ $category }}</span><span class="text-zinc-500">{{ $count }}</span></div>
                            <div class="h-2 overflow-hidden rounded-full bg-[#e7ded0]"><div class="admin-category-bar h-full rounded-full" style="transform: scaleX({{ $totalProducts > 0 ? $count / $totalProducts : 0 }})"></div></div>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500">Ongeza bidhaa ili kuona mchanganuo.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="admin-table-card rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Malipo ya COD</p>
                    <flux:heading size="lg" class="mt-2">Muhtasari wa fedha</flux:heading>
                </div>
                <a class="text-sm font-semibold text-[#a85335]" href="{{ route('admin.cash-collections') }}" wire:navigate>Angalia malipo</a>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-2xl border border-zinc-200 bg-[#fdf8f2] p-5">
                    <p class="text-xs uppercase tracking-[.14em] text-zinc-500">Jumla iliyopokelewa</p>
                    <p class="mt-3 text-3xl font-semibold text-[#a85335]">TZS {{ number_format((float) $totalCollected) }}</p>
                </div>
                <div class="rounded-2xl border border-zinc-200 bg-[#f3fbf5] p-5">
                    <p class="text-xs uppercase tracking-[.14em] text-zinc-500">Leo</p>
                    <p class="mt-3 text-3xl font-semibold text-emerald-700">TZS {{ number_format((float) $todayCollected) }}</p>
                </div>
                <div class="rounded-2xl border border-zinc-200 bg-[#f5f1e9] p-5">
                    <p class="text-xs uppercase tracking-[.14em] text-zinc-500">Rekodi</p>
                    <p class="mt-3 text-3xl font-semibold text-[#25251f]">{{ $recentCollections->count() }}</p>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
            <section class="admin-table-card admin-data-table overflow-hidden rounded-2xl border border-zinc-200 bg-[#fcfaf6] shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-5 dark:border-zinc-700"><div><flux:heading size="lg">Bidhaa za hivi karibuni</flux:heading><flux:subheading>Bidhaa zilizoongezwa mwisho</flux:subheading></div><a class="text-sm font-semibold text-[#a85335]" href="{{ route('admin.products') }}" wire:navigate>Simamia zote</a></div>
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($recentProducts as $product)
                        <div class="flex items-center justify-between gap-4 px-6 py-4"><div class="min-w-0"><p class="truncate font-medium">{{ $product->name }}</p><p class="mt-1 text-xs text-zinc-500">{{ $product->category }}</p></div><div class="text-right"><p class="font-medium">{{ $product->price ? 'TZS '.number_format((float) $product->price) : 'Bei haijawekwa' }}</p><span class="text-xs {{ $product->in_stock ? 'text-emerald-600' : 'text-amber-600' }}">{{ $product->in_stock ? 'Ipo stock' : 'Haipo stock' }}</span></div></div>
                    @empty
                        <p class="px-6 py-10 text-center text-sm text-zinc-500">Bado hujaongeza bidhaa.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
