@props(['title' => null, 'description' => null, 'noindex' => false, 'type' => 'website'])
@php
    $siteName = config('site.name');
    $pageTitle = $title ? $title.' · '.$siteName : $siteName.' — '.config('site.tagline');
    $pageDescription = $description ?? config('site.descriptor');
    $canonical = rtrim(config('app.url'), '/').request()->getPathInfo();
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    @if ($noindex)
        <meta name="robots" content="noindex">
    @else
        <link rel="canonical" href="{{ $canonical }}">
        <meta property="og:locale" content="es_AR">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:type" content="{{ $type }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:url" content="{{ $canonical }}">
        <meta name="twitter:card" content="summary">
    @endif
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <a class="visually-hidden-focusable" href="#contenido">Saltar al contenido</a>

    <x-site.header />

    <main id="contenido" class="flex-grow-1">
        {{ $slot }}
    </main>

    <x-site.footer />
</body>
</html>
