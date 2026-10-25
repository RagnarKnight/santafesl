@php
    $contact = \App\Support\SiteContact::fromConfig();
@endphp
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-5">
                <p class="h5 mb-2">{{ config('site.name') }}</p>
                <p class="mb-2 text-secondary">{{ config('site.descriptor') }}</p>
                <p class="small mb-0">Me interesa el software libre y la cultura maker: la tecnología se puede entender, adaptar y usar. <a href="{{ route('about') }}">Conocé más sobre mí</a></p>
            </div>
            <div class="col-6 col-md-4">
                <h2 class="h6">Secciones</h2>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('products.index') }}">Programas</a></li>
                    <li><a href="{{ route('services.index') }}">Servicios</a></li>
                    <li><a href="{{ route('about') }}">Sobre mí</a></li>
                    <li><a href="{{ route('contact') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="h6">Escribime</h2>
                @if ($contact->email())
                    <p class="mb-0"><a href="mailto:{{ $contact->email() }}">{{ $contact->email() }}</a>@if ($contact->emailIsExample()) <span class="small text-secondary">(ejemplo)</span>@endif</p>
                @else
                    <p class="mb-0"><a href="{{ route('contact') }}">Cómo contactarme</a></p>
                @endif
            </div>
        </div>
        <p class="footer-line small text-secondary mt-4 pt-3 mb-0">© {{ now()->year }} {{ config('site.name') }}. Todos los derechos reservados.</p>
    </div>
</footer>
