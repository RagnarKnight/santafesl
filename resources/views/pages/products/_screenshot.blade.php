{{-- Captura real de una ficha. Con «mobile» usa otra captura real de la misma pantalla en pantallas chicas. --}}
<figure class="screenshot {{ $screen['height'] > $screen['width'] ? 'screenshot--phone' : '' }} {{ $screen['mobile'] ? 'screenshot--adaptive' : '' }}">
    @if ($screen['mobile'])
        <picture>
            <source media="(max-width: 767.98px)" srcset="{{ Storage::disk('public')->url($screen['mobile']['image']) }}" width="{{ $screen['mobile']['width'] }}" height="{{ $screen['mobile']['height'] }}">
    @endif
    <img class="screenshot__img" src="{{ Storage::disk('public')->url($screen['image']) }}" alt="{{ $screen['alt'] }}" width="{{ $screen['width'] }}" height="{{ $screen['height'] }}" @unless ($eager) loading="lazy" decoding="async" @endunless>
    @if ($screen['mobile'])
        </picture>
    @endif
    <figcaption class="small text-secondary mt-2">Captura real de {{ $product->brand() }}.{{ $product->screens_note ? ' '.$product->screens_note : '' }} <a href="{{ Storage::disk('public')->url($screen['image']) }}">Ver la imagen completa</a></figcaption>
</figure>
