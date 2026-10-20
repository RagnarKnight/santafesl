<?php

it('envía las cabeceras de seguridad y una CSP sin inline', function () {
    $response = $this->get(route('home'))->assertOk();

    $csp = $response->headers->get('Content-Security-Policy');

    expect($response->headers->get('X-Content-Type-Options'))->toBe('nosniff')
        ->and($response->headers->get('X-Frame-Options'))->toBe('DENY')
        ->and($response->headers->get('Referrer-Policy'))->toBe('strict-origin-when-cross-origin')
        ->and($response->headers->get('Permissions-Policy'))->not->toBeEmpty()
        ->and($csp)->toContain("default-src 'self'")->toContain("frame-ancestors 'none'")
        ->and($csp)->not->toContain('unsafe-inline')->not->toContain('unsafe-eval')
        ->and($csp)->not->toContain('http');
});

it('también protege las páginas de error', function () {
    $this->get('/no-existe')->assertNotFound()->assertHeader('X-Content-Type-Options', 'nosniff');
});

it('no aplica la CSP en el entorno local para no bloquear el servidor de Vite', function () {
    $this->app->detectEnvironment(fn () => 'local');

    $this->get(route('home'))->assertOk()->assertHeaderMissing('Content-Security-Policy');
});
