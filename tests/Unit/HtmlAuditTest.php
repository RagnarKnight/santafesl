<?php

use Tests\Support\HtmlAudit;

const OWN_HOST = 'santafesl.com';

function audit(string $body): array
{
    return HtmlAudit::violations("<!DOCTYPE html><html lang=\"es\"><head><title>t</title></head><body>{$body}</body></html>", OWN_HOST);
}

it('detecta estilos inline', function (string $html) {
    expect(audit($html))->not->toBeEmpty();
})->with([
    'atributo style' => '<p style="color:red">x</p>',
    'elemento style' => '<style>p{color:red}</style>',
]);

it('detecta JavaScript inline', function (string $html) {
    expect(audit($html))->not->toBeEmpty();
})->with([
    'script con código' => '<script>alert(1)</script>',
    'manejador onclick' => '<button onclick="x()">x</button>',
    'URL javascript:' => '<a href="javascript:void(0)">x</a>',
]);

it('detecta recursos externos (CDN)', function (string $html) {
    expect(audit($html))->not->toBeEmpty();
})->with([
    'hoja de estilos' => '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">',
    'hoja de estilos sin protocolo' => '<link rel="stylesheet" href="//fonts.bunny.net/css?family=inter">',
    'preload de fuente' => '<link rel="preload" as="font" href="https://fonts.gstatic.com/x.woff2">',
    'script externo' => '<script src="https://unpkg.com/alpinejs"></script>',
    'imagen externa' => '<img src="https://example.com/a.png" alt="">',
    'imagen con srcset externo' => '<img src="/a.png" srcset="/a.png 1x, https://example.com/b.png 2x" alt="">',
]);

it('no genera falsos positivos con contenido legítimo', function (string $html) {
    expect(audit($html))->toBeEmpty();
})->with([
    'enlace externo normal' => '<a href="https://github.com/usuario" rel="noopener noreferrer">GitHub</a>',
    'enlace a WhatsApp' => '<a href="https://wa.me/5493420000000">WhatsApp</a>',
    'mailto' => '<a href="mailto:hola@example.com">Correo</a>',
    'canonical y alternate' => '<link rel="canonical" href="https://santafesl.com/"><link rel="alternate" href="https://otro.com/">',
    'recursos propios relativos' => '<link rel="stylesheet" href="/build/assets/app.css"><script type="module" src="/build/assets/app.js"></script><img src="/storage/a.png" alt="">',
    'recursos propios absolutos' => '<link rel="stylesheet" href="https://santafesl.com/build/app.css"><img src="//santafesl.com/a.png" alt="">',
    'JSON-LD como datos' => '<script type="application/ld+json">{"@context":"https://schema.org"}</script>',
    'texto que menciona style y onclick' => '<p>El atributo style y onclick no se usan; ver https://cdn.example.com</p>',
    'atributo cuyo nombre empieza con on pero no es un manejador' => '<div data-onboarding="1" aria-owns="x">x</div>',
]);

it('extrae los hosts externos de un texto e ignora los espacios de nombres', function () {
    $content = "url('https://fonts.bunny.net/x') xmlns='http://www.w3.org/2000/svg' // https://cdn.jsdelivr.net/a";

    expect(HtmlAudit::externalHosts($content))->toEqualCanonicalizing(['fonts.bunny.net', 'cdn.jsdelivr.net']);
    expect(HtmlAudit::externalHosts("xmlns='http://www.w3.org/2000/svg'"))->toBeEmpty();
});
