<?php

use App\Content\Catalog;
use App\Content\Entry;
use Illuminate\Support\Carbon;

function catalogWith(string $type, array $rows): Catalog
{
    $dir = sys_get_temp_dir().'/catalog-'.bin2hex(random_bytes(6));
    mkdir($dir);
    file_put_contents("{$dir}/{$type}.php", '<?php return '.var_export($rows, true).';');

    return new Catalog($dir);
}

function row(string $slug, array $extra = []): array
{
    return array_merge([
        'slug' => $slug,
        'name' => ucfirst($slug),
        'short_description' => "Descripción de {$slug}.",
        'published_at' => '2020-01-01',
    ], $extra);
}

it('muestra solo los elementos publicados', function () {
    $catalog = catalogWith('products', [
        row('publicado'),
        row('borrador', ['published_at' => null]),
        row('futuro', ['published_at' => Carbon::now()->addDays(3)->toDateString()]),
    ]);

    expect(array_map(fn (Entry $e) => $e->slug, $catalog->products()))->toBe(['publicado']);
    expect($catalog->product('borrador'))->toBeNull();
    expect($catalog->product('futuro'))->toBeNull();
    expect($catalog->product('publicado'))->toBeInstanceOf(Entry::class);
});

it('incluye los borradores solo cuando se piden', function () {
    $catalog = catalogWith('products', [row('a'), row('b', ['published_at' => null])]);

    expect($catalog->all('products', publishedOnly: false))->toHaveCount(2);
});

it('ordena por sort_order y luego por nombre', function () {
    $catalog = catalogWith('products', [
        row('zeta', ['sort_order' => 1]),
        row('beta', ['sort_order' => 2]),
        row('alfa', ['sort_order' => 2]),
    ]);

    expect(array_map(fn (Entry $e) => $e->slug, $catalog->products()))->toBe(['zeta', 'alfa', 'beta']);
});

it('devuelve solo los destacados', function () {
    $catalog = catalogWith('products', [row('a', ['featured' => true]), row('b')]);

    expect(array_map(fn (Entry $e) => $e->slug, $catalog->featuredProducts()))->toBe(['a']);
});

it('rechaza datos inválidos', function (array $row) {
    catalogWith('products', [$row])->products();
})->with([
    'sin nombre' => [['slug' => 'x', 'short_description' => 'd']],
    'sin descripción corta' => [['slug' => 'x', 'name' => 'X']],
    'slug con mayúsculas' => [row('Mal-Slug')],
    'slug con espacios' => [row('mal slug')],
    'estado inexistente' => [row('x', ['status' => 'volando'])],
    'imagen sin alt' => [row('x', ['image_path' => 'products/x/a.webp'])],
])->throws(InvalidArgumentException::class);

it('rechaza slugs duplicados', function () {
    catalogWith('products', [row('igual'), row('igual')])->products();
})->throws(InvalidArgumentException::class, 'Slug duplicado');

it('acepta imágenes decorativas con alt vacío y estados válidos', function () {
    $entry = catalogWith('projects', [row('p', ['image_path' => 'projects/p/a.webp', 'image_alt' => '', 'status' => 'experimental'])])->project('p');

    expect($entry->status)->toBe('experimental')
        ->and($entry->statusLabel())->toBe('Experimental');
});

it('divide la descripción en párrafos', function () {
    $entry = catalogWith('products', [row('x', ['description' => "Uno.\n\nDos.\r\n\r\n  Tres.  "])])->product('x');

    expect($entry->paragraphs())->toBe(['Uno.', 'Dos.', 'Tres.']);
});

it('usa el SEO propio o, si falta, el nombre y la descripción corta', function () {
    $entry = catalogWith('products', [row('x')])->product('x');

    expect($entry->metaTitle())->toBe('X')->and($entry->metaDescription())->toBe('Descripción de x.');
});
