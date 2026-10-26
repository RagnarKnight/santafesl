<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
// «Catálogo web» pasó a llamarse Pediwa: la dirección vieja redirige a la nueva.
Route::permanentRedirect('/productos/catalogo-web', '/productos/pediwa');
Route::get('/productos/{slug}', [ProductController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('products.show');

Route::get('/servicios', [ServiceController::class, 'index'])->name('services.index');

// Laboratorio: no publicado en la v1 (sus datos siguen en resources/content/projects.php).

Route::get('/sobre-mi', AboutController::class)->name('about');
Route::get('/contacto', ContactController::class)->name('contact');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
