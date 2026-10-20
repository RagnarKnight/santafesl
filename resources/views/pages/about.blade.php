<x-layouts.app title="Sobre mí" description="Quién está detrás de SantaFeSL y cómo trabaja.">
    <x-page-header title="Sobre mí" lead="Hago programas, cuido servidores y resuelvo problemas de tecnología para que a otros les resulte más fácil." />

    <section class="section">
        <div class="container">
            <div class="prose mb-5">
                <h2 class="h3">De dónde viene el nombre</h2>
                <p class="mb-0">SantaFeSL combina <strong>Santa Fe</strong>, por el lugar de donde soy, y <strong>SL</strong>, por <strong>Software Libre</strong>: programas que cualquiera puede usar, estudiar y mejorar sin depender de una sola empresa.</p>
            </div>

            <h2 class="h3 mb-2">Cómo trabajo</h2>
            <p class="mb-4 prose">Entiendo el problema, elijo una solución razonable y la mantengo simple.</p>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ([
                    ['Simple', 'Prefiero soluciones sencillas y claras antes que cosas complicadas porque sí.'],
                    ['Útil', 'Construyo tecnología para resolver necesidades reales.'],
                    ['Cercana', 'Te explico las cosas de manera que se entiendan, sin necesidad de saber de informática.'],
                    ['Honesta', 'No prometo cosas que no puedo cumplir.'],
                    ['Libre', 'Valoro el Software Libre y los estándares abiertos: permiten que las soluciones se puedan estudiar, modificar y mantener sin ataduras.'],
                    ['Duradera', 'Prefiero tecnologías conocidas y documentadas, que sigan funcionando con el tiempo.'],
                ] as [$title, $text])
                    <div class="col">
                        <div class="service-block h-100">
                            <h3 class="h5">{{ $title }}</h3>
                            <p class="mb-0">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-contact />
</x-layouts.app>
