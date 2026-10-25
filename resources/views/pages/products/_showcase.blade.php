{{-- Ficha con capturas reales: una sección por pantalla, otros módulos y video. Se activa con 'screens' en products.php. --}}
@php
    $dashboard = $product->screen('dashboard');
@endphp
<div class="container pt-4">
    <nav aria-label="Migas de pan">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Programas</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>
    <div class="prose text-secondary">
        @foreach ($product->paragraphs() as $paragraph)
            <p class="mb-2">{{ $paragraph }}</p>
        @endforeach
    </div>
</div>

@foreach ($product->screens as $screen)
    <section id="{{ $loop->first ? 'funcionalidades' : $screen['key'] }}" class="section product-section {{ $loop->even ? 'section--tint' : '' }}" aria-labelledby="titulo-{{ $screen['key'] }}">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <h2 id="titulo-{{ $screen['key'] }}" class="section-title mb-3">{{ $screen['heading'] }}</h2>
                    <p class="prose mb-0">{{ $screen['text'] }}</p>
                </div>
                <div class="col-lg-7">
                    <ul class="feature-list feature-list--stack">
                        @foreach ($screen['points'] as $point)
                            <li><span class="feature-list__tick"><x-icon name="check" :size="16" /></span><span>{{ $point }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <figure class="screenshot">
                <img class="screenshot__img" src="{{ Storage::disk('public')->url($screen['image']) }}" alt="{{ $screen['alt'] }}" width="{{ $screen['width'] }}" height="{{ $screen['height'] }}" @unless ($loop->first) loading="lazy" decoding="async" @endunless>
                <figcaption class="small text-secondary mt-2">Captura real de CHMS, con datos de ejemplo. <a href="{{ Storage::disk('public')->url($screen['image']) }}">Ver la imagen completa</a></figcaption>
            </figure>
        </div>
    </section>
@endforeach

@if ($product->modules !== [])
    <section id="modulos" class="section product-section" aria-labelledby="titulo-modulos">
        <div class="container">
            <h2 id="titulo-modulos" class="section-title mb-3">Y mucho más en un mismo sistema</h2>
            <p class="prose mb-4">Además de estas cuatro áreas, CHMS tiene otros módulos para el día a día de la iglesia. Cada iglesia tiene sus datos separados, y el sistema tiene modo oscuro y está pensado para usarse desde el celular.</p>
            <ul class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 list-unstyled mb-0">
                @foreach ($product->modules as $module)
                    <li class="col">
                        <div class="module-card h-100">
                            <span class="module-card__tile" aria-hidden="true"><x-icon :name="$module['icon']" :size="22" /></span>
                            <h3 class="h6 mb-1">{{ $module['name'] }}</h3>
                            <p class="small mb-0">{{ $module['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

<section id="demostracion" class="section pt-0 product-section" aria-labelledby="titulo-demostracion">
    <div class="container">
        <h2 id="titulo-demostracion" class="section-title mb-4">{{ $product->video ? 'Mirá CHMS en movimiento' : 'Una demostración en video, próximamente' }}</h2>

        @if ($product->video)
            <x-product.video :product="$product" />
        @elseif ($dashboard)
            <figure class="screenshot mb-3">
                <img class="screenshot__img" src="{{ Storage::disk('public')->url($dashboard['image']) }}" alt="Panel principal de CHMS, a la espera del video de demostración." width="{{ $dashboard['width'] }}" height="{{ $dashboard['height'] }}" loading="lazy" decoding="async">
            </figure>
            <p class="demo-note mb-0">La demostración en video estará disponible próximamente. Mientras tanto, podés pedirnos una demostración y te mostramos el sistema funcionando.</p>
        @endif
    </div>
</section>
