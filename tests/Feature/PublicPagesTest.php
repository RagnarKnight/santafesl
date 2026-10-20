<?php

use App\Content\Catalog;

dataset('public routes', [
    'inicio' => 'home',
    'productos' => 'products.index',
    'servicios' => 'services.index',
    'sobre mí' => 'about',
    'contacto' => 'contact',
]);

it('responde 200 con la estructura básica en cada página pública', function (string $routeName) {
    $response = $this->get(route($routeName))->assertOk();

    $html = $response->getContent();

    expect($html)
        ->toContain('<html lang="es">')
        ->toContain('<main id="contenido"')
        ->toContain('href="#contenido"')
        ->and(substr_count($html, '<h1'))->toBe(1);
})->with('public routes');

it('responde 200 en la ficha de cada producto publicado', function () {
    foreach (app(Catalog::class)->products() as $product) {
        $this->get(route('products.show', $product->slug))->assertOk()->assertSee($product->name);
    }
});

it('muestra los tres productos publicados con el estado Terminado', function () {
    $products = app(Catalog::class)->products();

    expect(array_map(fn ($p) => $p->slug, $products))->toBe(['chms-iglesias', 'pos', 'catalogo-web']);

    foreach ($products as $product) {
        expect($product->statusLabel())->toBe('Terminado');
        $this->get(route('products.show', $product->slug))->assertSee('Terminado');
    }

    $this->get(route('products.index'))->assertSee('Terminado');
});

it('no publica el Laboratorio: sin rutas, enlaces ni menciones visibles', function () {
    foreach (['/laboratorio', '/laboratorio/sincnetwork', '/laboratorio/netwatch'] as $url) {
        $this->get($url)->assertNotFound();
    }

    foreach (['home', 'products.index', 'services.index', 'about', 'contact', 'sitemap'] as $name) {
        $html = $this->get(route($name))->getContent();

        expect($html)->not->toContain('/laboratorio')->not->toContain('Laboratorio');
    }

    expect(app('router')->has('projects.index'))->toBeFalse();
    expect(app('router')->has('projects.show'))->toBeFalse();
});

it('conserva los datos internos de los proyectos sin publicarlos', function () {
    expect(array_map(fn ($p) => $p->slug, app(Catalog::class)->projects()))->toBe(['sincnetwork', 'netwatch']);

    $html = $this->get(route('home'))->getContent();

    expect($html)->not->toContain('SincNetwork')->not->toContain('Netwatch');
});

it('devuelve 404 para slugs inexistentes o inválidos', function (string $url) {
    $this->get($url)->assertNotFound();
})->with([
    '/productos/no-existe',
    '/productos/Mayusculas_y_guion_bajo',
    '/laboratorio',
    '/laboratorio/no-existe',
    '/servicios/desarrollo',
    '/admin',
    '/login',
]);

it('muestra una página 404 en español sin indexar', function () {
    $this->get('/productos/no-existe')
        ->assertNotFound()
        ->assertSee('Página no encontrada')
        ->assertSee('<meta name="robots" content="noindex">', false);
});

it('marca la sección activa con aria-current', function () {
    $this->get(route('services.index'))
        ->assertSee('aria-current="page"', false);

    expect(substr_count($this->get(route('services.index'))->getContent(), 'aria-current="page"'))->toBe(1);
});

it('publica un sitemap con todas las páginas y fichas publicadas', function () {
    $response = $this->get(route('sitemap'))->assertOk();

    expect($response->headers->get('Content-Type'))->toContain('application/xml');

    $xml = simplexml_load_string($response->getContent());
    $locs = array_map(fn ($url) => (string) $url->loc, iterator_to_array($xml->url, false));

    expect($locs)->toContain(route('home'), route('contact'));

    foreach (app(Catalog::class)->products() as $product) {
        expect($locs)->toContain(route('products.show', $product->slug));
    }

    expect($locs)->toHaveCount(8);
});

it('no envía cookies en el sitio público', function () {
    $response = $this->get(route('home'))->assertOk();

    expect($response->headers->getCookies())->toBeEmpty();
});
