@php
    $hero = config('site.hero');
@endphp
<x-layouts.app>
    <section class="hero" aria-labelledby="titulo-inicio">
        <div class="container">
            <div class="row align-items-center g-0 g-lg-5">
                <div class="col-lg-6">
                    <p class="eyebrow">Soluciones tecnológicas</p>
                    <h1 id="titulo-inicio" class="hero__title mb-3">Tecnología que te hace la vida <span class="text-highlight">más fácil</span>.</h1>
                    <p class="lead mb-4">Programas, páginas web y soluciones para tu negocio, sin complicaciones.</p>
                    <div class="d-grid d-sm-flex flex-wrap gap-3">
                        <a class="btn btn-primary btn-lg" href="{{ route('contact') }}"><x-icon name="chat" :size="20" /> Contame qué necesitás</a>
                        <a class="btn btn-outline-primary btn-lg" href="{{ route('products.index') }}">Ver nuestros programas →</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img class="hero__art" src="{{ Storage::disk('public')->url($hero['image']) }}" alt="{{ $hero['alt'] }}" width="{{ $hero['width'] }}" height="{{ $hero['height'] }}" fetchpriority="high">
                </div>
            </div>
        </div>
    </section>

    <section class="section" aria-labelledby="titulo-productos">
        <div class="container">
            <h2 id="titulo-productos" class="section-title mb-3">Programas para tu día a día</h2>
            <p class="mb-4 prose text-secondary">Herramientas pensadas para resolver tareas reales sin complicaciones.</p>
            @if ($products === [])
                <p>Pronto vas a encontrar acá nuestros programas.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 g-lg-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <x-entry-card :entry="$product" :href="route('products.show', $product->slug)" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="section pt-0" aria-labelledby="titulo-servicios">
        <div class="container">
            <h2 id="titulo-servicios" class="section-title mb-3">¿En qué podemos ayudarte?</h2>
            <p class="mb-4 prose text-secondary">Nos ocupamos de la tecnología para que vos puedas ocuparte de lo tuyo.</p>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                @foreach ($services as $service)
                    <div class="col">
                        <x-service-block :service="$service" />
                    </div>
                @endforeach
            </div>
            <div class="d-grid d-md-block">
                <a class="btn btn-outline-primary btn-lg" href="{{ route('services.index') }}">Ver todos los servicios →</a>
            </div>
        </div>
    </section>

    <x-cta-contact />
</x-layouts.app>
