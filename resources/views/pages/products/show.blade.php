<x-layouts.app :title="$product->metaTitle()" :description="$product->metaDescription()">
    <x-page-header :title="$product->name" :lead="$product->short_description">
        @if ($product->statusLabel())
            <p class="mt-3 mb-0"><x-status-badge :label="$product->statusLabel()" /></p>
        @endif
    </x-page-header>

    <section class="section">
        <div class="container">
            <nav aria-label="Migas de pan">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Programas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            @if ($product->imageUrl())
                <img class="img-fluid rounded-4 border mb-4 detail-art" src="{{ $product->imageUrl() }}" alt="{{ $product->image_alt }}">
            @endif

            <div class="prose">
                @foreach ($product->paragraphs() as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach

                @if ($product->features !== [])
                    <h2 class="h4 mt-4">Qué incluye</h2>
                    <ul>
                        @foreach ($product->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

    <x-cta-contact />
</x-layouts.app>
