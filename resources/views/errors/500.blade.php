<x-layouts.app title="Error del servidor" :noindex="true">
    <x-page-header title="Algo salió mal" lead="Tuvimos un problema para mostrar esta página. Probá de nuevo en unos minutos." />
    <section class="section">
        <div class="container">
            <a class="btn btn-primary btn-lg" href="{{ route('home') }}">Volver al inicio</a>
        </div>
    </section>
</x-layouts.app>
