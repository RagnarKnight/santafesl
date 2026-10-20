<?php

it('incluye un favicon provisional válido y no vacío', function () {
    expect(filesize(public_path('favicon.ico')))->toBeGreaterThan(100);
    expect(file_get_contents(public_path('favicon.ico'), false, null, 0, 4))->toBe("\x00\x00\x01\x00");

    $svg = new DOMDocument;
    expect($svg->loadXML(file_get_contents(public_path('favicon.svg'))))->toBeTrue();
    expect($svg->documentElement->nodeName)->toBe('svg');
});

it('declara el favicon en el encabezado de cada página', function () {
    $html = $this->get(route('home'))->getContent();

    expect($html)->toContain('favicon.svg')->toContain('favicon.ico');
});
