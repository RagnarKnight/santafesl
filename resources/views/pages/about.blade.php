<x-layouts.app title="Sobre mí" description="Quién está detrás de SantaFeSL: software libre, cultura maker y una forma de trabajar simple, útil y honesta.">
    <x-page-header title="Sobre mí" lead="Hago programas, cuido servidores y resuelvo problemas de tecnología para que a otros les resulte más fácil." />

    <section class="section">
        <div class="container">
            <div class="prose mb-5">
                <h2 class="h3">De dónde viene el nombre</h2>
                <p class="mb-0">SantaFeSL combina <strong>Santa Fe</strong>, por el lugar de donde soy, y <strong>SL</strong>, por <strong>Software Libre</strong>: programas que cualquiera puede usar, estudiar y mejorar sin depender de una sola empresa.</p>
            </div>

            <div class="mb-5">
                <h2 class="h3">Software libre y cultura maker</h2>
                <div class="prose">
                    <p>Me interesa el software libre y me identifico con su activismo. También me atrae la cultura maker: aprender haciendo, probar y arreglar con las propias manos.</p>
                    <p>Creo que la tecnología no tiene por qué ser una caja negra: podemos comprenderla, adaptarla y usarla para resolver problemas concretos. Por eso, en SantaFeSL prefiero soluciones que puedas entender y mantener, y te explico cómo funcionan.</p>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mt-2">
                    @foreach ([
                        ['Autonomía', 'Poder decidir sobre las herramientas que usás.'],
                        ['Aprendizaje', 'Entender cómo funcionan las cosas.'],
                        ['Experimentación', 'Probar, equivocarse y mejorar.'],
                        ['Uso consciente', 'Elegir la tecnología con criterio, no por moda.'],
                    ] as [$value, $meaning])
                        <div class="col">
                            <div class="service-block h-100">
                                <h3 class="h6 mb-1">{{ $value }}</h3>
                                <p class="small mb-0">{{ $meaning }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
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
