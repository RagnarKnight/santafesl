<x-layouts.app title="Programas" description="Programas de SantaFeSL para iglesias y negocios.">
    <x-page-header title="Programas para tu día a día" lead="Herramientas pensadas para resolver tareas reales sin complicarte." />

    <section class="section">
        <div class="container">
            @if ($products === [])
                <p>Todavía no hay programas publicados.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <x-entry-card :entry="$product" :href="route('products.show', $product->slug)" level="2" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta-contact />
</x-layouts.app>
