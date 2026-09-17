<x-layouts.app>
    <div class="admin-report-page flex w-full flex-1 flex-col gap-8">
        <header class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Mahecha Furniture / Reports</p>
                <flux:heading size="xl" class="mt-2">Ripoti ya bidhaa</flux:heading>
                <flux:subheading class="mt-1">Muhtasari wa catalog, stock na taarifa zinazohitaji kukamilishwa.</flux:subheading>
                <p class="mt-3 text-xs text-zinc-500">Imetengenezwa {{ now()->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex flex-wrap gap-3 print:hidden">
                <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.products') }}" wire:navigate>Bidhaa</flux:button>
                <flux:button variant="primary" icon="printer" type="button" onclick="window.print()" class="!bg-[#a85335] !text-white hover:!bg-[#25251f]">Chapisha report</flux:button>
            </div>
        </header>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Bidhaa zote</p><p class="mt-3 text-3xl font-semibold">{{ $products->count() }}</p><p class="mt-1 text-xs text-zinc-500">Kwenye catalog</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Zinapatikana</p><p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $products->where('in_stock', true)->count() }}</p><p class="mt-1 text-xs text-zinc-500">Zinaonekana website</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Thamani ya bei</p><p class="mt-3 text-2xl font-semibold text-[#a85335]">TZS {{ number_format((float) $totalValue) }}</p><p class="mt-1 text-xs text-zinc-500">{{ $pricedProducts }} bidhaa zenye bei</p></div>
            <div class="admin-stat-card rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"><p class="text-xs font-semibold uppercase tracking-[.14em] text-zinc-500">Inahitaji umakini</p><p class="mt-3 text-3xl font-semibold text-amber-700">{{ $products->whereNull('price')->count() + $missingImageCount }}</p><p class="mt-1 text-xs text-zinc-500">Bei au picha zimekosekana</p></div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[.8fr_1.2fr]">
            <section class="admin-table-card rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between gap-3"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Distribution</p><flux:heading size="lg" class="mt-2">Bidhaa kwa category</flux:heading></div><flux:icon name="chart-bar" class="size-5 text-[#a85335]" /></div>
                <div class="mt-6 space-y-5">
                    @forelse ($categoryBreakdown as $category => $count)
                        <div><div class="mb-1.5 flex justify-between text-sm"><span class="font-semibold">{{ $category }}</span><span class="text-zinc-500">{{ $count }}</span></div><div class="h-2 overflow-hidden rounded-full bg-[#e7ded0]"><div class="h-full rounded-full bg-[#a85335]" style="width: {{ $products->count() > 0 ? ($count / $products->count()) * 100 : 0 }}%"></div></div></div>
                    @empty
                        <p class="text-sm text-zinc-500">Hakuna category bado.</p>
                    @endforelse
                </div>
            </section>

            <section class="admin-table-card rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-3"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Data quality</p><flux:heading size="lg" class="mt-2">Vitu vya kukamilisha</flux:heading></div><a class="text-sm font-semibold text-[#a85335] print:hidden" href="{{ route('admin.products') }}" wire:navigate>Simamia</a></div>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-amber-50 p-4"><p class="text-xs text-amber-800">Bila bei</p><p class="mt-1 text-2xl font-semibold text-amber-900">{{ $products->whereNull('price')->count() }}</p><p class="mt-1 text-xs text-amber-800">Weka bei ili report iwe kamili.</p></div>
                    <div class="rounded-xl bg-[#f5f1e9] p-4"><p class="text-xs text-[#777269]">Bila picha</p><p class="mt-1 text-2xl font-semibold text-[#25251f]">{{ $missingImageCount }}</p><p class="mt-1 text-xs text-[#777269]">Picha huongeza uaminifu wa catalog.</p></div>
                </div>
            </section>
        </div>

            <section class="admin-table-card admin-data-table overflow-hidden rounded-2xl border border-zinc-200 bg-[#fcfaf6] shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 px-6 py-5 dark:border-zinc-700"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#a85335]">Full inventory</p><flux:heading size="lg" class="mt-2">Orodha ya bidhaa</flux:heading></div><span class="text-sm text-zinc-500">{{ $products->count() }} records</span></div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px] text-left text-sm">
                    <thead class="bg-[#f5f1e9] text-xs uppercase tracking-[.12em] text-[#777269]"><tr><th class="px-6 py-4 font-semibold">Bidhaa</th><th class="px-6 py-4 font-semibold">Category</th><th class="px-6 py-4 font-semibold">Bei</th><th class="px-6 py-4 font-semibold">Stock</th><th class="px-6 py-4 font-semibold">Taarifa</th></tr></thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($products as $product)
                            <tr><td class="px-6 py-4 font-semibold">{{ $product->name }}</td><td class="px-6 py-4 text-zinc-500">{{ $product->category }}</td><td class="px-6 py-4">{{ $product->price ? 'TZS '.number_format((float) $product->price) : 'Haijawekwa' }}</td><td class="px-6 py-4"><span class="font-semibold {{ $product->in_stock ? 'text-emerald-700' : 'text-amber-700' }}">{{ $product->in_stock ? 'Ipo stock' : 'Haipo stock' }}</span></td><td class="px-6 py-4 text-xs text-zinc-500">{{ $product->image_path ? 'Picha ipo' : 'Bila picha' }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-zinc-500">Hakuna bidhaa za kuripoti.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.app>
