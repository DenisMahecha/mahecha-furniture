<div>
<div class="catalog-controls" aria-label="Tafuta bidhaa">
    <label class="catalog-search">
        <span class="sr-only">Tafuta bidhaa</span>
        <span aria-hidden="true">⌕</span>
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Tafuta bidhaa...">
    </label>
    <div class="catalog-filters" role="group" aria-label="Chuja kwa aina ya bidhaa">
        <button type="button" wire:click="$set('category', 'Zote')" class="catalog-filter {{ $category === 'Zote' ? 'is-active' : '' }}">Zote</button>
        @foreach ($categories as $availableCategory)
            <button type="button" wire:click="$set('category', '{{ $availableCategory }}')" class="catalog-filter {{ $category === $availableCategory ? 'is-active' : '' }}">{{ $availableCategory }}</button>
        @endforeach
    </div>
</div>
<div class="catalog-result-line" aria-live="polite">
    <span>{{ $products->count() }} {{ $products->count() === 1 ? 'bidhaa inapatikana' : 'bidhaa zinapatikana' }}</span>
    @if ($search !== '' || $category !== 'Zote')
        <button type="button" wire:click="$set('search', ''); $set('category', 'Zote')">Ondoa vichujio <span aria-hidden="true">×</span></button>
    @endif
</div>
<div class="product-grid">
    @forelse ($products as $product)
        <article class="product-card product-{{ $product['accent'] }}">
            <a href="{{ $product['whatsappLink'] }}" target="_blank" rel="noopener" class="product-image-link" aria-label="{{ $product['price'] ? 'Agiza' : 'Uliza bei ya' }} {{ $product['name'] }} WhatsApp">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }} za Mahecha Furniture" loading="lazy">
                <span class="image-arrow" aria-hidden="true">↗</span>
            </a>
            <div class="product-details">
                <p class="product-eyebrow">{{ $product['eyebrow'] }}</p>
                <h3>{{ $product['name'] }}</h3>
                @if ($product['price'])
                    <strong class="product-price">TZS {{ number_format((float) $product['price']) }}</strong>
                @else
                    <strong class="product-price product-price-muted">Bei kwa mawasiliano</strong>
                @endif
                <p>{{ $product['description'] }}</p>
                <a class="product-link whatsapp-button" href="{{ $product['whatsappLink'] }}" target="_blank" rel="noopener">{{ $product['price'] ? 'Agiza WhatsApp' : 'Uliza bei WhatsApp' }} <span aria-hidden="true">↗</span></a>
            </div>
        </article>
    @empty
        <p class="section-lead">Bidhaa zinaandaliwa. Wasiliana nasi WhatsApp kupata maelezo zaidi.</p>
    @endforelse
</div>
</div>
