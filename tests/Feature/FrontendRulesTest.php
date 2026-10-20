<?php

use App\Content\Catalog;
use Tests\Support\HtmlAudit;

function allPublicUrls(): array
{
    $catalog = app(Catalog::class);
    $urls = [route('home'), route('products.index'), route('services.index'), route('about'), route('contact'), url('/pagina-que-no-existe')];

    foreach ($catalog->products() as $product) {
        $urls[] = route('products.show', $product->slug);
    }

    return $urls;
}

it('no genera CSS ni JavaScript inline ni recursos externos en ninguna página', function () {
    $host = parse_url(config('app.url'), PHP_URL_HOST);

    foreach (allPublicUrls() as $url) {
        $violations = HtmlAudit::violations($this->get($url)->getContent(), $host);

        expect($violations)->toBe([], "Violaciones en {$url}: ".implode('; ', $violations));
    }
});

it('no referencia CDN ni fuentes remotas en el código fuente', function () {
    $files = [base_path('vite.config.js')];

    foreach ([resource_path('css'), resource_path('js'), resource_path('views')] as $directory) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {
            $files[] = $file->getPathname();
        }
    }

    foreach ($files as $file) {
        $content = file_get_contents($file);

        expect(HtmlAudit::externalHosts($content))->toBe([], "{$file} referencia hosts externos");
    }

    expect(file_get_contents(base_path('vite.config.js')))->not->toContain('bunny')->not->toContain('fonts:');
});

it('no incluye librerías prohibidas', function () {
    $npm = json_decode(file_get_contents(base_path('package.json')), true);
    $composer = json_decode(file_get_contents(base_path('composer.json')), true);

    $npmDependencies = array_keys(array_merge($npm['dependencies'] ?? [], $npm['devDependencies'] ?? []));
    $composerDependencies = array_keys(array_merge($composer['require'] ?? [], $composer['require-dev'] ?? []));

    foreach (['tailwindcss', '@tailwindcss/vite', 'jquery', 'alpinejs', 'vue', 'react', 'axios', '@fortawesome/fontawesome-free'] as $forbidden) {
        expect($npmDependencies)->not->toContain($forbidden);
    }

    expect($npmDependencies)->toContain('bootstrap', 'sass', '@fontsource/inter');

    foreach (['livewire/livewire', 'laravel/breeze', 'laravel/jetstream', 'laravel/fortify', 'laravel/sanctum'] as $forbidden) {
        expect($composerDependencies)->not->toContain($forbidden);
    }
});

it('no deja recursos externos en los assets compilados', function () {
    $assets = array_merge(glob(public_path('build/assets/*.css')) ?: [], glob(public_path('build/assets/*.js')) ?: []);

    foreach ($assets as $asset) {
        expect(HtmlAudit::externalHosts(file_get_contents($asset)))->toBe([], "{$asset} referencia hosts externos");
    }
})->skip(fn () => glob(public_path('build/assets/*.css')) === [], 'Falta compilar los assets (npm run build).');
