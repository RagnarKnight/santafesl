<?php

use App\Content\Catalog;
use Illuminate\Support\Facades\Storage;

function illustrationFiles(): array
{
    return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
}

it('incluye las ilustraciones provisionales esperadas', function (string $name) {
    expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
})->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);

it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
    $xml = file_get_contents($file);

    expect(strlen($xml))->toBeLessThan(20_000);

    $dom = new DOMDocument;
    expect($dom->loadXML($xml))->toBeTrue();
    expect($dom->documentElement->nodeName)->toBe('svg');

    foreach (['script', 'foreignObject', 'style', 'image', 'use', 'a', 'iframe'] as $tag) {
        expect($dom->getElementsByTagName($tag)->length)->toBe(0, "<{$tag}> no permitido en {$file}");
    }

    foreach ((new DOMXPath($dom))->query('//@*') as $attr) {
        expect(strtolower($attr->nodeName))->not->toStartWith('on')->not->toContain('href');
        expect($attr->nodeValue)->not->toContain('http')->not->toContain('url(')->not->toContain('javascript:');
    }

    expect(str_replace('http://www.w3.org/2000/svg', '', $xml))->not->toContain('http');
})->with(fn () => array_map(fn ($f) => [$f], illustrationFiles()));

it('usa en el contenido solo imágenes que existen y llevan texto alternativo', function () {
    $catalog = app(Catalog::class);

    foreach (array_merge($catalog->products(), $catalog->projects()) as $entry) {
        expect($entry->image_path)->not->toBeNull();
        expect($entry->image_alt)->not->toBeEmpty();
        expect(Storage::disk('public')->exists($entry->image_path))->toBeTrue();
    }
});

it('muestra la ilustración de portada configurada en el inicio', function () {
    $hero = config('site.hero');

    expect(Storage::disk('public')->exists($hero['image']))->toBeTrue();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(Storage::disk('public')->url($hero['image']), false)
        ->assertSee($hero['alt']);
});

it('sirve las imágenes con rutas relativas, sin depender de APP_URL', function () {
    config(['app.url' => 'http://otro-host.test']);

    expect(Storage::disk('public')->url('illustrations/hero-technology.svg'))->toBe('/storage/illustrations/hero-technology.svg');
});

it('muestra los párrafos de la ficha sin secuencias de escape literales', function () {
    $this->get(route('products.show', 'chms-iglesias'))
        ->assertOk()
        ->assertDontSee('\n', false)
        ->assertSee('También se lo conoce como CHMS');
});

it('publica storage/app/public mediante el enlace public/storage versionado', function () {
    expect(is_link(public_path('storage')))->toBeTrue();
    expect(realpath(public_path('storage')))->toBe(realpath(storage_path('app/public')));
});
