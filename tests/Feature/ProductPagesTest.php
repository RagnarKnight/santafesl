<?php

use App\Content\Catalog;
use App\Content\Entry;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

const REAL_NUMBER = '5491155550123';

/** Mensajes exactos pedidos para cada producto. */
dataset('whatsapp messages', [
    'iglesias' => ['chms-iglesias', 'Hola, quisiera conocer más sobre el sistema CHMS para iglesias de SantaFeSL y solicitar una demostración.'],
    'caja' => ['pos', 'Hola, quisiera conocer más sobre el sistema de caja de SantaFeSL y solicitar una demostración.'],
    'pediwa' => ['pediwa', 'Hola, quisiera conocer más sobre Pediwa de SantaFeSL y consultar cómo podría usarlo en mi negocio.'],
]);

function product(array $extra = []): Entry
{
    return Entry::fromArray('products', array_merge([
        'slug' => 'prueba',
        'name' => 'Programa de prueba',
        'short_description' => 'Un programa de prueba.',
    ], $extra));
}

it('genera el mensaje de WhatsApp de cada producto con el formato oficial y bien codificado', function (string $slug, string $message) {
    config(['site.contact.whatsapp' => REAL_NUMBER, 'site.contact.email' => null]);

    $html = $this->get(route('products.show', $slug))->assertOk()->getContent();

    preg_match_all('#href="(https://wa\.me/[^"]+)"#', $html, $m);

    // Un botón arriba y otro al final de la ficha, ambos con el mismo mensaje.
    expect($m[1])->toHaveCount(2)->and(array_unique($m[1]))->toHaveCount(1);

    $url = html_entity_decode($m[1][0]);
    $parts = parse_url($url);

    expect($parts['host'])->toBe('wa.me')
        ->and($parts['path'])->toBe('/'.REAL_NUMBER)
        ->and($url)->not->toContain(' ');

    parse_str($parts['query'], $query);
    expect($query['text'])->toBe($message);
})->with('whatsapp messages');

it('usa el número centralizado en la configuración y no lo escribe en ninguna vista', function () {
    config(['site.contact.whatsapp' => '5491166660000', 'site.contact.email' => null]);

    $this->get(route('products.show', 'pos'))->assertSee('https://wa.me/5491166660000?text=', false);

    foreach (glob(resource_path('views/**/*.blade.php')) ?: [] as $view) {
        expect(file_get_contents($view))->not->toMatch('#wa\.me/\d#');
    }
});

it('sin WhatsApp usa el correo y, sin correo, la página de contacto: nunca un enlace roto', function () {
    config(['site.contact.whatsapp' => null, 'site.contact.email' => 'hola@santafesl.test']);

    $this->get(route('products.show', 'pos'))
        ->assertOk()
        ->assertDontSee('wa.me', false)
        ->assertSee('mailto:hola@santafesl.test?subject=Consulta%20por%20Sistema%20de%20caja', false);

    config(['site.contact.email' => null]);

    $this->get(route('products.show', 'pos'))
        ->assertDontSee('wa.me', false)
        ->assertDontSee('mailto:', false)
        ->assertSee('href="'.route('contact').'"', false);
});

it('no muestra el número de ejemplo en producción', function () {
    config(['site.contact.whatsapp' => '5490000000000', 'site.contact.email' => 'contacto@example.com']);
    $this->app->detectEnvironment(fn () => 'production');

    $this->get(route('products.show', 'pos'))
        ->assertOk()
        ->assertDontSee('wa.me', false)
        ->assertDontSee('example.com');
});

it('marca el número de ejemplo fuera de producción', function () {
    config(['site.contact.whatsapp' => '5490000000000']);

    $this->get(route('products.show', 'pos'))->assertSee('Número de ejemplo');
});

it('usa llamadas a la acción específicas en las tarjetas y no «Conocer más»', function () {
    $html = $this->get(route('products.index'))->assertOk()->getContent();

    expect($html)->toContain('Ver cómo funciona')->toContain('Explorar funciones')
        ->and($html)->not->toContain('Conocer más');

    $home = $this->get(route('home'))->getContent();
    expect($home)->toContain('Ver cómo funciona')->not->toContain('Conocer más');
});

it('lleva cada llamada a la acción a su ficha o a su sección y esa sección existe', function () {
    $index = $this->get(route('products.index'))->getContent();

    expect($index)
        ->toContain('href="'.route('products.show', 'chms-iglesias').'#funcionalidades"')
        ->toContain('href="'.route('products.show', 'pos').'#funciones"')
        ->toContain('href="'.route('products.show', 'pediwa').'#como-funciona"')
        ->not->toContain('catalogo-web');

    $this->get(route('products.show', 'pos'))->assertSee('id="funciones"', false);
    $this->get(route('products.show', 'pediwa'))->assertSee('id="como-funciona"', false);
});

it('presenta cada producto con problema, público, funciones y demostración', function (string $slug) {
    $product = app(Catalog::class)->product($slug);

    expect($product->features)->toHaveCount(4)->and(count($product->features))->toBeBetween(4, 6);

    $page = $this->get(route('products.show', $slug))->assertOk()
        ->assertSee('Qué problema resuelve')->assertSee('Para quién es')
        ->assertSee('id="demostracion"', false)->assertSee('id="funciones"', false)
        ->assertSee('id="consultar"', false);

    foreach ($product->features as $feature) {
        $page->assertSee($feature);
    }

    // Un solo h1 y jerarquía sin saltos.
    $html = $page->getContent();
    expect(substr_count($html, '<h1'))->toBe(1);
})->with(['pos']);

it('avisa que las funciones son orientativas mientras no estén confirmadas', function () {
    $this->get(route('products.show', 'pos'))
        ->assertSee('Funciones de referencia')
        ->assertSee('orientativa')
        ->assertDontSee('Qué incluye');
});

it('sin video muestra la maqueta como ilustración conceptual y no un reproductor vacío', function (string $slug) {
    $html = $this->get(route('products.show', $slug))->assertOk()
        ->assertSee('No es una captura de pantalla real')
        ->assertSee('Todavía no hay un video')
        ->assertSee('role="img"', false)
        ->getContent();

    expect($html)->not->toContain('<video')->not->toContain('<iframe')->not->toContain('product-video');
})->with(['pos']);

it('las maquetas no usan estilos en línea ni imágenes externas', function (string $type) {
    $html = Blade::render('<x-product.mockup :type="$type" />', ['type' => $type]);

    expect($html)->toContain('mockup--'.$type)->not->toContain('style=')->not->toContain('<img')->not->toContain('http');
})->with(Entry::MOCKUPS);

it('tiene títulos y descripciones propios en cada producto', function () {
    $titles = [];
    $descriptions = [];

    foreach (app(Catalog::class)->products() as $product) {
        expect($product->seo_title)->not->toBeNull()->and($product->seo_description)->not->toBeNull()
            ->and(strlen($product->seo_description))->toBeLessThanOrEqual(175);

        $titles[] = $product->seo_title;
        $descriptions[] = $product->seo_description;

        $this->get(route('products.show', $product->slug))
            ->assertSee('<title>'.e($product->seo_title).' · SantaFeSL</title>', false)
            ->assertSee('<meta name="description" content="'.e($product->seo_description).'">', false);
    }

    expect(array_unique($titles))->toHaveCount(count($titles))->and(array_unique($descriptions))->toHaveCount(count($descriptions));
});

// --- Video -------------------------------------------------------------------

it('dibuja un video local sin descargarlo hasta que se reproduce', function () {
    $product = product(['video' => [
        'provider' => 'local', 'src' => 'videos/demo.mp4', 'poster' => 'videos/demo.jpg',
        'orientation' => 'vertical', 'title' => 'Demostración de prueba', 'description' => 'Un recorrido corto.',
    ]]);

    $html = Blade::render('<x-product.video :product="$product" />', ['product' => $product]);

    expect($html)
        ->toContain('<video')->toContain('controls')->toContain('preload="none"')
        ->toContain('poster="'.Storage::disk('public')->url('videos/demo.jpg').'"')
        ->toContain('type="video/mp4"')->toContain('product-video--vertical')
        ->toContain('aria-label="Demostración de prueba"')->toContain('Un recorrido corto.')
        ->not->toContain('autoplay')->not->toContain('style=');
});

it('dibuja un video externo como portada con botón y sin cargar nada de afuera', function () {
    $product = product(['video' => [
        'provider' => 'embed', 'url' => 'https://www.youtube-nocookie.com/embed/abc',
        'poster' => 'videos/demo.jpg', 'title' => 'Demo externa',
    ]]);

    $html = Blade::render('<x-product.video :product="$product" />', ['product' => $product]);

    expect($html)
        ->toContain('data-video-embed="https://www.youtube-nocookie.com/embed/abc"')
        ->toContain('aria-label="Reproducir el video: Demo externa"')
        ->toContain('product-video--horizontal')
        ->not->toContain('<iframe')->not->toContain('<video')->not->toContain('src="https://');
});

it('no dibuja nada si el producto no tiene video', function () {
    expect(trim(Blade::render('<x-product.video :product="$product" />', ['product' => product()])))->toBe('');
});

it('rechaza videos mal definidos', function (array $video) {
    product(['video' => $video]);
})->throws(InvalidArgumentException::class)->with([
    'proveedor desconocido' => [['provider' => 'ftp', 'title' => 'x', 'poster' => 'p.jpg']],
    'sin portada' => [['provider' => 'local', 'src' => 'a.mp4', 'title' => 'x']],
    'sin título' => [['provider' => 'local', 'src' => 'a.mp4', 'poster' => 'p.jpg']],
    'local sin archivo' => [['provider' => 'local', 'title' => 'x', 'poster' => 'p.jpg']],
    'externo sin https' => [['provider' => 'embed', 'url' => 'http://example.com/v', 'title' => 'x', 'poster' => 'p.jpg']],
    'orientación inválida' => [['provider' => 'local', 'src' => 'a.mp4', 'title' => 'x', 'poster' => 'p.jpg', 'orientation' => 'diagonal']],
]);

it('solo referencia videos y portadas que existen y proveedores permitidos', function () {
    foreach (app(Catalog::class)->all(Catalog::PRODUCTS, publishedOnly: false) as $product) {
        if ($product->video === null) {
            continue;
        }

        expect(Storage::disk('public')->exists($product->video['poster']))->toBeTrue("Falta la portada de {$product->slug}");

        if ($product->video['provider'] === 'local') {
            expect(Storage::disk('public')->exists($product->video['src']))->toBeTrue("Falta el video de {$product->slug}");
        } else {
            expect(config('site.video_hosts'))->toContain(parse_url($product->video['url'], PHP_URL_HOST));
        }
    }

    expect(true)->toBeTrue();
});

it('mantiene la CSP estricta y solo agrega frame-src para los dominios de video configurados', function () {
    expect(SecurityHeaders::policy())->toBe(SecurityHeaders::CONTENT_SECURITY_POLICY)
        ->and(config('site.video_hosts'))->toBe([]);

    config(['site.video_hosts' => ['www.youtube-nocookie.com', 'no válido!', 'https://x.com']]);

    $csp = SecurityHeaders::policy();

    expect($csp)->toStartWith(SecurityHeaders::CONTENT_SECURITY_POLICY)
        ->toContain('frame-src https://www.youtube-nocookie.com')
        ->not->toContain('no válido')->not->toContain('x.com')
        ->not->toContain('unsafe-inline')->not->toContain('*');
});

// --- Servicios y «Sobre mí» --------------------------------------------------

it('explica cada servicio por su beneficio y enlaza a los programas', function () {
    $page = $this->get(route('services.index'))->assertOk()
        ->assertSee('Tu web, lista para funcionar')->assertSee('Una red que funcione como debe')->assertSee('Un programa hecho para vos')
        ->assertSee('href="'.route('products.index').'"', false);

    foreach (app(Catalog::class)->services() as $service) {
        expect($service->description)->not->toBeEmpty();
        $page->assertSee($service->description);
    }
});

it('la portada conserva «Ver todos los servicios» apuntando a una página existente', function () {
    $this->get(route('home'))->assertSee('Ver todos los servicios')->assertSee('href="'.route('services.index').'"', false);
    $this->get(route('services.index'))->assertOk();
});

it('presenta el perfil de software libre y cultura maker sin inventar datos', function () {
    $this->get(route('about'))->assertOk()
        ->assertSee('Software libre y cultura maker')
        ->assertSee('caja negra')
        ->assertSee('Autonomía')->assertSee('Aprendizaje')->assertSee('Experimentación')->assertSee('Uso consciente');
});

it('el pie de página presenta «Sobre mí» y enlaza a la página', function () {
    $this->get(route('home'))
        ->assertSee('software libre y la cultura maker')
        ->assertSee('href="'.route('about').'"', false);
});

// --- CHMS: ficha con capturas reales ------------------------------------------

it('presenta CHMS con su título, descripción y los dos botones principales', function () {
    config(['site.contact.whatsapp' => REAL_NUMBER]);

    $html = $this->get(route('products.show', 'chms-iglesias'))->assertOk()
        ->assertSee('CHMS: la gestión de tu iglesia, más organizada')
        ->assertSee('acompañá su proceso de consolidación')
        ->assertSee('Solicitar una demostración')
        ->assertSee('href="#funcionalidades"', false)
        ->assertSee('id="funcionalidades"', false)
        ->assertSee('<title>CHMS: sistema de gestión para iglesias · SantaFeSL</title>', false)
        ->getContent();

    expect(substr_count($html, '<h1'))->toBe(1);
});

it('muestra las cuatro capturas reales con texto alternativo, tamaño y carga diferida', function () {
    $product = app(Catalog::class)->product('chms-iglesias');

    expect(array_column($product->screens, 'key'))->toBe(['dashboard', 'consolidacion', 'eventos', 'tesoreria']);

    $html = $this->get(route('products.show', 'chms-iglesias'))->getContent();

    foreach ($product->screens as $i => $screen) {
        $path = Storage::disk('public')->path($screen['image']);

        expect(is_file($path))->toBeTrue("Falta {$screen['image']}");

        [$w, $h] = getimagesize($path);
        expect([$w, $h])->toBe([$screen['width'], $screen['height']])
            ->and(strlen($screen['alt']))->toBeGreaterThan(40)
            ->and($screen['points'])->not->toBeEmpty();

        expect($html)->toContain('alt="'.e($screen['alt']).'"')
            ->toContain('width="'.$screen['width'].'" height="'.$screen['height'].'"')
            ->toContain('id="titulo-'.$screen['key'].'"');
    }

    // Solo la primera captura se carga de inmediato; el resto, al acercarse.
    preg_match_all('#<img class="screenshot__img"[^>]*>#', $html, $imgs);
    expect($imgs[0])->toHaveCount(5)
        ->and($imgs[0][0])->not->toContain('loading="lazy"');
    foreach (array_slice($imgs[0], 1) as $tag) {
        expect($tag)->toContain('loading="lazy"');
    }
});

it('explica las etapas de consolidación y los datos de eventos y tesorería sin mezclar pagado con pendiente', function () {
    $this->get(route('products.show', 'chms-iglesias'))
        ->assertSee('Visita, Decisión, Discipulado, Bautismo y Miembro activo')
        ->assertSee('lo pagado y lo pendiente')
        ->assertSee('Cuánto hay que recaudar, cuánto se recaudó y cuánto falta')
        ->assertSee('ingresos, egresos o ambos')
        ->assertSee('Ingresos, egresos y balance del día');
});

it('agrupa los otros ocho módulos en tarjetas compactas', function () {
    $product = app(Catalog::class)->product('chms-iglesias');

    expect($product->modules)->toHaveCount(8);

    $page = $this->get(route('products.show', 'chms-iglesias'))->assertSee('id="modulos"', false);

    foreach ($product->modules as $module) {
        $page->assertSee($module['name']);
    }
});

it('sin video real muestra la captura del panel y un aviso discreto, sin reproductor', function () {
    $html = $this->get(route('products.show', 'chms-iglesias'))
        ->assertSee('La demostración en video estará disponible próximamente')
        ->getContent();

    expect($html)->not->toContain('<video')->not->toContain('<iframe')->not->toContain('product-video')
        ->and($html)->toContain('id="demostracion"');
});

it('con un video real, la ficha de CHMS usa el reproductor en lugar de la alternativa', function () {
    $data = require resource_path('content/products.php');
    $row = collect($data)->firstWhere('slug', 'chms-iglesias');
    $row['video'] = ['provider' => 'local', 'src' => 'videos/chms.mp4', 'poster' => 'videos/chms.jpg', 'title' => 'CHMS en movimiento'];

    $product = Entry::fromArray('products', $row);
    $html = Blade::render('@include("pages.products._showcase")', ['product' => $product]);

    expect($html)->toContain('<video')->toContain('preload="none"')->not->toContain('estará disponible próximamente');
});

it('la ficha de CHMS usa el mismo contacto centralizado y cae al correo o a /contacto', function () {
    config(['site.contact.whatsapp' => null, 'site.contact.email' => null]);

    $this->get(route('products.show', 'chms-iglesias'))
        ->assertDontSee('wa.me', false)
        ->assertSee('href="'.route('contact').'"', false)
        ->assertSee('¿Querés conocer CHMS en funcionamiento?');
});

it('rechaza capturas y módulos mal definidos', function (array $extra) {
    product($extra);
})->throws(InvalidArgumentException::class)->with([
    'captura sin alt' => [['screens' => [['key' => 'a', 'image' => 'x.webp', 'width' => 10, 'height' => 10, 'heading' => 'h', 'text' => 't']]]],
    'captura sin tamaño' => [['screens' => [['key' => 'a', 'image' => 'x.webp', 'alt' => 'a', 'heading' => 'h', 'text' => 't']]]],
    'módulo con icono inexistente' => [['modules' => [['name' => 'M', 'text' => 't', 'icon' => 'nada']]]],
]);

// --- Pediwa: ficha con collage, capturas del panel y pasos --------------------

it('presenta Pediwa con su título, descripción y los dos botones pedidos', function () {
    config(['site.contact.whatsapp' => REAL_NUMBER]);

    $html = $this->get(route('products.show', 'pediwa'))->assertOk()
        ->assertSee('Tu catálogo digital, listo para vender por WhatsApp.')
        ->assertSee('recibí pedidos por WhatsApp')
        ->assertSee('Consultar por WhatsApp')
        ->assertSee('Conocer cómo funciona')
        ->assertSee('href="#como-funciona"', false)
        ->assertSee('<title>Pediwa: catálogo digital para vender por WhatsApp · SantaFeSL</title>', false)
        ->getContent();

    expect(substr_count($html, '<h1'))->toBe(1);
});

it('muestra el collage y las cuatro capturas con sus proporciones originales', function () {
    $product = app(Catalog::class)->product('pediwa');

    expect(array_column($product->screens, 'key'))->toBe(['panel', 'productos', 'banners', 'categorias']);

    $files = [$product->hero_image, ...$product->screens];
    $html = $this->get(route('products.show', 'pediwa'))->getContent();

    foreach ($files as $file) {
        $path = Storage::disk('public')->path($file['image']);
        [$w, $h] = getimagesize($path);

        expect([$w, $h])->toBe([$file['width'], $file['height']])
            ->and(strlen($file['alt']))->toBeGreaterThan(40)
            ->and($html)->toContain('alt="'.e($file['alt']).'"')->toContain('width="'.$file['width'].'" height="'.$file['height'].'"');
    }
});

it('explica el flujo en tres pasos y aclara que no es una tienda con pagos', function () {
    $this->get(route('products.show', 'pediwa'))
        ->assertSee('id="como-funciona"', false)
        ->assertSee('El cliente explora el catálogo')->assertSee('Arma su carrito')->assertSee('Envía el pedido por WhatsApp')
        ->assertSee('no es una tienda online con pagos integrados')
        ->assertSee('El comerciante continúa la venta manualmente');
});

it('no promete resultados comerciales ni funciones no verificadas', function () {
    $html = strtolower(strip_tags($this->get(route('products.show', 'pediwa'))->getContent()));

    foreach (['multiplic', 'duplic', '24 horas', 'automáticamente', 'garantiz', 'testimonio', 'pasarela', 'mercado pago', 'se guardan'] as $banned) {
        expect($html)->not->toContain($banned);
    }
});

it('lista los cinco rubros de los catálogos de ejemplo', function () {
    $this->get(route('products.show', 'pediwa'))
        ->assertSee('id="rubros"', false)
        ->assertSee('Kioscos y almacenes')->assertSee('Indumentaria')->assertSee('Comida')->assertSee('Frutas y verduras')->assertSee('Tecnología');
});

it('Pediwa usa el contacto central y no muestra video vacío', function () {
    config(['site.contact.whatsapp' => null, 'site.contact.email' => null]);

    $html = $this->get(route('products.show', 'pediwa'))
        ->assertDontSee('wa.me', false)
        ->assertSee('href="'.route('contact').'"', false)
        ->assertSee('Empezá a mostrar tu negocio de otra manera.')
        ->getContent();

    expect($html)->not->toContain('<video')->not->toContain('estará disponible próximamente');
});

it('rechaza secciones mal definidas', function (array $extra) {
    product($extra);
})->throws(InvalidArgumentException::class)->with([
    'tipo inválido' => [['intro_sections' => [['type' => 'otra', 'id' => 'a', 'title' => 't', 'items' => ['x']]]]],
    'sin ítems' => [['intro_sections' => [['type' => 'checks', 'id' => 'a', 'title' => 't', 'items' => []]]]],
    'tarjeta sin título' => [['outro_sections' => [['type' => 'cards', 'id' => 'a', 'title' => 't', 'items' => [['text' => 'x']]]]]],
    'collage sin tamaño' => [['hero_image' => ['image' => 'x.webp', 'alt' => 'a']]],
]);

it('la dirección vieja del «Catálogo web» redirige a Pediwa y ya no figura entre los programas', function () {
    $this->get('/productos/catalogo-web')->assertRedirect('/productos/pediwa')->assertStatus(301);

    expect(array_map(fn ($p) => $p->slug, app(Catalog::class)->products()))->not->toContain('catalogo-web');
    $this->get(route('products.index'))->assertDontSee('Catálogo web');
});
