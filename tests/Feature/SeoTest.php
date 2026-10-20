<?php

use App\Content\Catalog;

function publicUrls(): array
{
    $catalog = app(Catalog::class);
    $urls = [route('home'), route('products.index'), route('services.index'), route('about'), route('contact')];

    foreach ($catalog->products() as $product) {
        $urls[] = route('products.show', $product->slug);
    }

    return $urls;
}

function metaContent(string $html, string $selector): ?string
{
    $document = new DOMDocument;
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML('<?xml encoding="UTF-8">'.$html);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    $node = $xpath->query($selector)->item(0);

    return $node?->nodeValue;
}

it('define título único, descripción, canonical y Open Graph en cada página', function () {
    $titles = [];

    foreach (publicUrls() as $url) {
        $html = $this->get($url)->assertOk()->getContent();
        $path = parse_url($url, PHP_URL_PATH) ?: '/';

        $title = metaContent($html, '//title');
        $titles[] = $title;

        expect($title)->not->toBeEmpty()
            ->and(metaContent($html, '//meta[@name="description"]/@content'))->not->toBeEmpty()
            ->and(metaContent($html, '//link[@rel="canonical"]/@href'))->toBe(rtrim(config('app.url'), '/').$path)
            ->and(metaContent($html, '//meta[@property="og:title"]/@content'))->toBe($title)
            ->and(metaContent($html, '//meta[@property="og:url"]/@content'))->toBe(rtrim(config('app.url'), '/').$path);
    }

    expect($titles)->toBe(array_values(array_unique($titles)));
});

it('no usa el Host de la petición para construir el canonical', function () {
    $html = $this->get('http://otro-dominio.test/')->getContent();

    expect(metaContent($html, '//link[@rel="canonical"]/@href'))->not->toContain('otro-dominio.test');
});

it('mantiene un robots.txt con la referencia al sitemap', function () {
    $robots = file_get_contents(public_path('robots.txt'));

    expect($robots)->toContain('User-agent: *')->toContain('Sitemap: ');
});
