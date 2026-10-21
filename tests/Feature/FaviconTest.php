<?php

it('incluye el favicon: un .ico con varios tamaños y un PNG, ambos válidos', function () {
    expect(filesize(public_path('favicon.ico')))->toBeGreaterThan(1000);
    expect(file_get_contents(public_path('favicon.ico'), false, null, 0, 4))->toBe("\x00\x00\x01\x00");

    $png = getimagesize(public_path('favicon.png'));

    expect($png[2])->toBe(IMAGETYPE_PNG)
        ->and($png[0])->toBe($png[1])
        ->and($png[0])->toBeGreaterThanOrEqual(180);
});

it('declara el favicon en el encabezado de cada página', function () {
    $html = $this->get(route('home'))->getContent();

    expect($html)->toContain('favicon.ico')->toContain('favicon.png');
});

it('muestra el logo SFSL en el encabezado con el nombre del sitio como texto alternativo', function () {
    expect(storage_path('app/public/brand/logo.png'))->toBeFile();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('/storage/brand/logo.png', false)
        ->assertSee('alt="SantaFeSL"', false);
});
