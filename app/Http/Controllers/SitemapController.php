<?php

namespace App\Http\Controllers;

use App\Content\Catalog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(Catalog $catalog): Response
    {
        $urls = [
            route('home'),
            route('products.index'),
            route('services.index'),
            route('about'),
            route('contact'),
        ];

        foreach ($catalog->products() as $product) {
            $urls[] = route('products.show', $product->slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
