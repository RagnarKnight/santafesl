<?php

use App\Content\Catalog;
use App\Content\Entry;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

dataset('content types', [Catalog::PRODUCTS, Catalog::SERVICES, Catalog::PROJECTS]);

// Los servicios se ilustran con iconos y no tienen imagen: solo estos tipos pueden llevarla.
dataset('types with images', [Catalog::PRODUCTS, Catalog::PROJECTS]);

it('carga y valida el contenido real (incluidos los borradores)', function (string $type) {
    $entries = app(Catalog::class)->all($type, publishedOnly: false);

    expect($entries)->not->toBeEmpty();

    $slugs = array_map(fn ($e) => $e->slug, $entries);
    expect($slugs)->toBe(array_values(array_unique($slugs)));
})->with('content types');

it('no publica marcas de contenido pendiente', function (string $type) {
    foreach (app(Catalog::class)->all($type) as $entry) {
        expect(json_encode($entry))->not->toContain('POR DEFINIR');
    }
})->with('content types');

it('referencia solo imágenes que existen en el disco público', function (string $type) {
    $checked = 0;

    foreach (app(Catalog::class)->all($type, publishedOnly: false) as $entry) {
        if ($entry->image_path !== null) {
            expect(Storage::disk('public')->exists($entry->image_path))
                ->toBeTrue("Falta la imagen {$entry->image_path} de {$entry->slug}");
            $checked++;
        }
    }

    // Si no hubiera ninguna imagen que comprobar, la prueba no demostraría nada.
    expect($checked)->toBeGreaterThan(0);
})->with('types with images');

it('ilustra los servicios con iconos propios y no con imágenes', function () {
    foreach (app(Catalog::class)->services() as $service) {
        expect($service->image_path)->toBeNull()
            ->and($service->icon)->not->toBeNull()
            ->and(Entry::ICONS)->toContain($service->icon);
    }
});

it('usa solo iconos propios existentes y los dibuja como SVG decorativo', function () {
    $catalog = app(Catalog::class);

    foreach (array_merge($catalog->products(), $catalog->services(), $catalog->projects()) as $entry) {
        if ($entry->icon === null) {
            continue;
        }

        expect(Entry::ICONS)->toContain($entry->icon);

        $html = Blade::render('<x-icon :name="$name" />', ['name' => $entry->icon]);

        expect($html)->toContain('<svg')->toContain('aria-hidden="true"')->not->toContain('style=');
    }
});

it('rechaza un icono desconocido', function () {
    Entry::fromArray('products', ['slug' => 'x', 'name' => 'X', 'short_description' => 'x', 'icon' => 'inexistente']);
})->throws(InvalidArgumentException::class);
