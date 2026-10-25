@props(['product'])
@php
    $video = $product->video;
    $mime = $video !== null && $video['provider'] === 'local'
        ? (['mp4' => 'video/mp4', 'webm' => 'video/webm', 'ogv' => 'video/ogg'][strtolower(pathinfo($video['src'], PATHINFO_EXTENSION))] ?? null)
        : null;
@endphp
{{-- Reproductor reutilizable. Sin video (video = null) no dibuja nada: la ficha muestra la alternativa visual. --}}
@if ($video !== null)
    <figure class="product-video product-video--{{ $video['orientation'] }}">
        @if ($video['provider'] === 'local')
            {{-- preload="none": no se descarga el video hasta que la persona le da a reproducir. --}}
            <video class="product-video__media" controls preload="none" playsinline poster="{{ $product->posterUrl() }}" aria-label="{{ $video['title'] }}">
                <source src="{{ Storage::disk('public')->url($video['src']) }}" @if ($mime) type="{{ $mime }}" @endif>
                <p class="p-3 mb-0">Tu navegador no puede reproducir este video. <a href="{{ Storage::disk('public')->url($video['src']) }}">Descargalo</a>.</p>
            </video>
        @else
            {{-- Proveedor externo: se carga recién al tocar el botón (resources/js/video-embed.js). --}}
            <div class="product-video__embed" data-video-embed="{{ $video['url'] }}" data-video-title="{{ $video['title'] }}">
                <img class="product-video__poster" src="{{ $product->posterUrl() }}" alt="" loading="lazy">
                <button class="product-video__play" type="button" aria-label="Reproducir el video: {{ $video['title'] }}"><x-icon name="play" :size="28" /></button>
                <noscript><a class="product-video__fallback" href="{{ $video['url'] }}">Ver el video: {{ $video['title'] }}</a></noscript>
            </div>
        @endif
        @if ($video['description'])
            <figcaption class="small text-secondary mt-2">{{ $video['description'] }}</figcaption>
        @endif
    </figure>
@endif
