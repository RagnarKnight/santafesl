<x-layouts.app title="Contacto" description="Cómo contactar a SantaFeSL.">
    <x-page-header title="¿Tenés algo en mente?" lead="Contame qué necesitás y vemos si podemos resolverlo." />

    <section class="section">
        <div class="container prose">
            @if ($contact->hasAny())
                <div class="d-flex flex-column align-items-start gap-4">
                    @if ($contact->email())
                        <div>
                            <p class="mb-2 text-secondary">Por correo</p>
                            <a class="btn btn-primary btn-lg" href="mailto:{{ $contact->email() }}">{{ $contact->email() }}</a>
                            @if ($contact->emailIsExample())
                                <p class="small text-secondary mt-2 mb-0">Correo de ejemplo: reemplazalo antes de publicar.</p>
                            @endif
                        </div>
                    @endif
                    @if ($contact->whatsappUrl())
                        <div>
                            <p class="mb-2 text-secondary">Por WhatsApp</p>
                            <a class="btn btn-primary btn-lg" href="{{ $contact->whatsappUrl() }}" rel="noopener noreferrer">Escribir por WhatsApp</a>
                            @if ($contact->whatsappIsExample())
                                <p class="small text-secondary mt-2 mb-0">Número de ejemplo: reemplazalo antes de publicar.</p>
                            @endif
                        </div>
                    @endif
                </div>
            @else
                <p class="fs-5">Los canales de contacto todavía no están publicados. Volvé a visitar esta página en los próximos días.</p>
            @endif
        </div>
    </section>
</x-layouts.app>
