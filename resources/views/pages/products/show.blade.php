<x-layouts.app :title="$product->metaTitle()" :description="$product->metaDescription()">
    <x-page-header :title="$product->pageTitle()" :lead="$product->pageLead()">
        @if ($product->statusLabel())
            <p class="mt-3 mb-0"><x-status-badge :label="$product->statusLabel()" /></p>
        @endif
        <div class="product-lead-actions">
            <x-product.contact-button :product="$product" :label="$product->cta_button ?? 'Solicitar una demostración'" />
            @if ($product->screens !== [])
                <a class="btn btn-outline-primary btn-lg" href="#{{ $product->explore_anchor ?? 'funcionalidades' }}">{{ $product->explore_label ?? 'Explorar las funcionalidades' }}</a>
            @elseif ($product->features !== [])
                <a class="btn btn-outline-primary btn-lg" href="#funciones">Ver las funciones</a>
            @endif
        </div>
        @if ($product->hero_image)
            {{-- En el celular el collage se ve más grande y se desliza dentro de su marco (la página no se desplaza). --}}
            <figure class="hero-shot" tabindex="0" role="group" aria-label="{{ $product->brand() }}: catálogos de ejemplo. Deslizá para ver todos.">
                <img class="hero-shot__img" src="{{ Storage::disk('public')->url($product->hero_image['image']) }}" alt="{{ $product->hero_image['alt'] }}" width="{{ $product->hero_image['width'] }}" height="{{ $product->hero_image['height'] }}" fetchpriority="high">
            </figure>
            <p class="small text-secondary d-md-none mt-2 mb-0">Deslizá la imagen para ver los cinco catálogos.</p>
        @endif
    </x-page-header>

    @if ($product->screens !== [])
        @include('pages.products._showcase')
    @else
    <section class="section pb-0">
        <div class="container">
            <nav aria-label="Migas de pan">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Programas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row g-4 g-lg-5 align-items-start">
                <div class="col-lg-7">
                    <div class="prose mb-4">
                        @foreach ($product->paragraphs() as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @if ($product->problem)
                            <div class="col">
                                <div class="service-block h-100">
                                    <h2 class="h5">Qué problema resuelve</h2>
                                    <p class="mb-0">{{ $product->problem }}</p>
                                </div>
                            </div>
                        @endif
                        @if ($product->audience)
                            <div class="col">
                                <div class="service-block h-100">
                                    <h2 class="h5">Para quién es</h2>
                                    <p class="mb-0">{{ $product->audience }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($product->imageUrl())
                    <div class="col-lg-5">
                        <img class="product-art" src="{{ $product->imageUrl() }}" alt="{{ $product->image_alt }}" width="400" height="300">
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($product->video || $product->mockup)
        <section id="demostracion" class="section product-section" aria-labelledby="titulo-demostracion">
            <div class="container">
                <h2 id="titulo-demostracion" class="section-title mb-4">{{ $product->video ? 'Mirá el video' : 'Cómo podría verse' }}</h2>

                @if ($product->video)
                    <x-product.video :product="$product" />
                @else
                    <figure class="mb-3">
                        <x-product.mockup :type="$product->mockup" />
                        <figcaption class="small text-secondary mt-2">Ilustración conceptual de la interfaz, hecha para esta página. No es una captura de pantalla real.</figcaption>
                    </figure>
                    <p class="demo-note mb-0">Todavía no hay un video de este programa. Pedí una demostración y te lo mostramos funcionando.</p>
                @endif
            </div>
        </section>
    @endif

    @if ($product->features !== [])
        <section id="funciones" class="section pt-0 product-section" aria-labelledby="titulo-funciones">
            <div class="container">
                <h2 id="titulo-funciones" class="section-title mb-4">{{ $product->features_confirmed ? 'Qué incluye' : 'Funciones de referencia' }}</h2>
                <ul class="feature-list mb-3">
                    @foreach ($product->features as $feature)
                        <li><span class="feature-list__tick"><x-icon name="check" :size="16" /></span><span>{{ $feature }}</span></li>
                    @endforeach
                </ul>
                @unless ($product->features_confirmed)
                    <p class="small text-secondary prose mb-0">Esta lista es orientativa: describe el tipo de ayuda de un programa como este. Las funciones exactas se confirman al coordinar la demostración.</p>
                @endunless
            </div>
        </section>
    @endif

    @endif

    <section id="consultar" class="cta-section product-section" aria-labelledby="titulo-consultar">
        <div class="container">
            <div class="cta-card">
                <span class="cta-card__icon" aria-hidden="true"><x-icon name="chat" :size="26" /></span>
                <div class="cta-card__text">
                    <h2 id="titulo-consultar" class="h4 mb-1">{{ $product->cta_title ?? '¿Querés conocer este programa?' }}</h2>
                    <p class="mb-0">{{ $product->cta_text ?? 'Escribime y coordinamos una demostración, sin compromiso.' }}</p>
                </div>
                <x-product.contact-button :product="$product" class="btn-light" :label="$product->cta_button ?? 'Solicitar una demostración'" />
            </div>
            @php($contact = \App\Support\SiteContact::fromConfig())
            @if ($contact->whatsappIsExample() && $contact->whatsappUrl($product->inquiryMessage()))
                <p class="small text-secondary mt-2 mb-0">Número de ejemplo: reemplazalo antes de publicar.</p>
            @endif
            <p class="mt-4 mb-0">
                <a class="more-link" href="{{ route('products.index') }}">Ver los otros programas</a>
                <span class="mx-2 text-secondary" aria-hidden="true">·</span>
                <a class="more-link" href="{{ route('services.index') }}">¿Necesitás algo a medida?</a>
            </p>
        </div>
    </section>
</x-layouts.app>
