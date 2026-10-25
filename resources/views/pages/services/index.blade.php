<x-layouts.app title="Servicios" description="Servicios de SantaFeSL: puesta en marcha de páginas web y servidores, diagnóstico y configuración de redes, y programas a medida.">
    <x-page-header title="¿En qué podemos ayudarte?" lead="Contanos qué problema tenés: nos ocupamos de la parte técnica para que vos puedas dedicarte a lo tuyo." />

    <section class="section">
        <div class="container">
            @if ($services === [])
                <p>Todavía no hay servicios publicados.</p>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4 g-lg-5">
                    @foreach ($services as $service)
                        <div class="col">
                            <x-service-block :service="$service" level="2" :details="true" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="section pt-0" aria-labelledby="titulo-programas-listos">
        <div class="container">
            <div class="prose">
                <h2 id="titulo-programas-listos" class="h4">¿Preferís algo que ya está hecho?</h2>
                <p>Además de los desarrollos a medida, tenemos programas terminados para iglesias y negocios.</p>
                <a class="more-link" href="{{ route('products.index') }}">Ver los programas</a>
            </div>
        </div>
    </section>

    <x-cta-contact />
</x-layouts.app>
