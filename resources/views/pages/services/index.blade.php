<x-layouts.app title="Servicios" description="Ayuda con servidores, redes y programas a medida.">
    <x-page-header title="¿En qué podemos ayudarte?" lead="Nos ocupamos de la tecnología para que vos puedas ocuparte de lo tuyo." />

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

    <x-cta-contact />
</x-layouts.app>
