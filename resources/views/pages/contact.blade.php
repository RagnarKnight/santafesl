<x-layouts.app title="Contacto" description="Cómo contactar a SantaFeSL.">
    <x-page-header title="¿Tenés algo en mente?" lead="Contame qué necesitás y vemos si podemos resolverlo." />

    <section class="section py-5">
        <div class="container">
            @if ($contact->hasAny())
                <div class="row g-4 justify-content-center">

                    {{-- Tarjeta de Email --}}
                    @if ($contact->email())
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="card h-100 border-0 shadow-sm text-center p-4">
                                <div class="mb-3 text-primary"><x-icon name="mail" :size="40" /></div>
                                <h5 class="card-title fw-bold">Por correo electrónico</h5>
                                <p class="card-text text-secondary mb-3">
                                    Envianos un email y te responderemos a la brevedad.
                                </p>
                                <a class="btn btn-primary btn-lg w-100" href="mailto:{{ $contact->email() }}">
                                    {{ $contact->email() }}
                                </a>
                                @if ($contact->emailIsExample())
                                    <p class="small text-warning mt-3 mb-0">
                                        <span class="me-1 d-inline-block align-text-bottom"><x-icon name="alert" :size="16" /></span>
                                        Correo de ejemplo: reemplazalo antes de publicar.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Tarjeta de WhatsApp --}}
                    @if ($contact->whatsappUrl())
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="card h-100 border-0 shadow-sm text-center p-4">
                                <div class="mb-3 text-success"><x-icon name="chat" :size="40" /></div>
                                <h5 class="card-title fw-bold">Por WhatsApp</h5>
                                <p class="card-text text-secondary mb-3">
                                    Escribinos directamente para una respuesta más rápida.
                                </p>
                                <a class="btn btn-success btn-lg w-100" href="{{ $contact->whatsappUrl() }}" rel="noopener noreferrer">
                                    Escribir por WhatsApp
                                </a>
                                @if ($contact->whatsappIsExample())
                                    <p class="small text-warning mt-3 mb-0">
                                        <span class="me-1 d-inline-block align-text-bottom"><x-icon name="alert" :size="16" /></span>
                                        Número de ejemplo: reemplazalo antes de publicar.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3 text-secondary"><x-icon name="inbox" :size="48" /></div>
                    <p class="fs-5 text-muted">Los canales de contacto todavía no están publicados. Volvé a visitar esta página en los próximos días.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
