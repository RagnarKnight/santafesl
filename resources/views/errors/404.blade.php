<x-layouts.app title="Página no encontrada" :noindex="true">
    <x-page-header title="Página no encontrada" lead="La página que buscás no existe o ya no está disponible. No pasa nada: podés volver al inicio." />
    <section class="section">
        <div class="container">
            <a class="btn btn-primary btn-lg" href="{{ route('home') }}">Volver al inicio</a>
        </div>
    </section>
</x-layouts.app>
