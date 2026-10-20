@props(['entry', 'href' => null, 'level' => 3, 'variant' => 'product'])
<article class="card card--{{ $variant }} h-100">
    @if ($entry->imageUrl())
        <img class="card-img-top" src="{{ $entry->imageUrl() }}" alt="{{ $entry->image_alt }}" width="400" height="300" loading="lazy">
    @endif
    @if ($entry->icon)
        <span class="card__tile" aria-hidden="true"><x-icon :name="$entry->icon" :size="26" /></span>
    @endif
    <div class="card-body">
        <h{{ $level }} class="h4 card-title">
            @if ($href)
                <a class="stretched-link text-decoration-none" href="{{ $href }}">{{ $entry->name }}</a>
            @else
                {{ $entry->name }}
            @endif
        </h{{ $level }}>
        @if ($entry->statusLabel())
            <p class="mb-2"><x-status-badge :label="$entry->statusLabel()" /></p>
        @endif
        <p class="card-text mb-0">{{ $entry->short_description }}</p>
        @if ($href)
            <p class="more-link mt-2 mt-md-3 mb-0" aria-hidden="true">Conocer más</p>
        @endif
    </div>
    @if ($href)
        <span class="card__go" aria-hidden="true"><x-icon name="arrow" :size="18" /></span>
    @endif
</article>
