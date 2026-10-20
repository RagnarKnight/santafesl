@php
    $links = [
        ['route' => 'products.index', 'match' => 'products.*', 'label' => 'Programas'],
        ['route' => 'services.index', 'match' => 'services.*', 'label' => 'Servicios'],
        ['route' => 'about', 'match' => 'about', 'label' => 'Sobre mí'],
    ];
@endphp
<header class="site-header">
    <nav class="navbar navbar-expand-lg" aria-label="Principal">
        <div class="container">
            <a class="navbar-brand brand-wordmark" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>SantaFe<span class="brand-wordmark__sl">SL</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu-principal" aria-controls="menu-principal" aria-expanded="false" aria-label="Mostrar u ocultar el menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu-principal">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    @foreach ($links as $link)
                        <li class="nav-item">
                            <a class="nav-link @if (request()->routeIs($link['match'])) active @endif" href="{{ route($link['route']) }}" @if (request()->routeIs($link['match'])) aria-current="page" @endif>{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-primary" href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif>Escribime</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
