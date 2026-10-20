<?php

use App\Support\SiteContact;

it('muestra el correo y el enlace oficial de WhatsApp configurados', function () {
    config([
        'site.contact.email' => 'hola@santafesl.test',
        'site.contact.whatsapp' => '5491155550123',
        'site.contact.whatsapp_message' => 'Hola, quiero consultar.',
    ]);

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('mailto:hola@santafesl.test', false)
        ->assertSee('https://wa.me/5491155550123?text=Hola%2C%20quiero%20consultar.', false)
        ->assertDontSee('de ejemplo');
});

it('normaliza el número de WhatsApp a solo dígitos', function () {
    config(['site.contact.email' => null, 'site.contact.whatsapp' => '+54 (911) 5555-0123', 'site.contact.whatsapp_message' => null]);

    $this->get(route('contact'))->assertSee('href="https://wa.me/5491155550123"', false);
});

it('explica que no hay canales publicados cuando no se configuró ninguno', function () {
    config(['site.contact.email' => null, 'site.contact.whatsapp' => null]);

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('todavía no están publicados')
        ->assertDontSee('mailto:', false)
        ->assertDontSee('wa.me', false);
});

it('ignora un correo o un número inválidos', function (?string $email, ?string $whatsapp) {
    config(['site.contact.email' => $email, 'site.contact.whatsapp' => $whatsapp]);

    $this->get(route('contact'))
        ->assertDontSee('mailto:', false)
        ->assertDontSee('wa.me', false);
})->with([
    'correo sin dominio' => ['hola@', '123'],
    'texto cualquiera' => ['javascript:alert(1)', 'abc'],
    'número demasiado largo' => [null, '12345678901234567'],
]);

it('marca los datos de ejemplo como ejemplo fuera de producción', function () {
    config(['site.contact.email' => 'contacto@example.com', 'site.contact.whatsapp' => SiteContact::EXAMPLE_WHATSAPP]);

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('Correo de ejemplo')
        ->assertSee('Número de ejemplo');
});

it('nunca presenta datos de ejemplo como contacto real en producción', function () {
    config(['site.contact.email' => 'contacto@example.com', 'site.contact.whatsapp' => SiteContact::EXAMPLE_WHATSAPP]);
    app()->detectEnvironment(fn () => 'production');

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('todavía no están publicados')
        ->assertDontSee('example.com')
        ->assertDontSee('wa.me', false);
});

it('usa el mismo contacto en el pie de página', function () {
    config(['site.contact.email' => 'hola@santafesl.test']);

    $this->get(route('home'))->assertSee('mailto:hola@santafesl.test', false);
});

it('mantiene el .env.example con valores de ejemplo reconocidos como tales', function () {
    $env = file_get_contents(base_path('.env.example'));

    preg_match('/^SITE_CONTACT_EMAIL=(.*)$/m', $env, $email);
    preg_match('/^SITE_CONTACT_WHATSAPP=(.*)$/m', $env, $whatsapp);

    expect(trim($email[1]))->toEndWith('@example.com')
        ->and(trim($whatsapp[1]))->toBe(SiteContact::EXAMPLE_WHATSAPP);
});

it('no incluye ningún formulario', function () {
    $this->get(route('contact'))->assertDontSee('<form', false);
});

it('trata como ejemplo cualquier número que termine en ocho ceros', function () {
    config(['site.contact.email' => null, 'site.contact.whatsapp' => '5491100000000']);

    $this->get(route('contact'))->assertSee('Número de ejemplo');

    app()->detectEnvironment(fn () => 'production');

    $this->get(route('contact'))->assertDontSee('wa.me', false);
});
