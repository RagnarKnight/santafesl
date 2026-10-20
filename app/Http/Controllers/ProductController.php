<?php

namespace App\Http\Controllers;

use App\Content\Catalog;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(Catalog $catalog): View
    {
        return view('pages.products.index', ['products' => $catalog->products()]);
    }

    public function show(Catalog $catalog, string $slug): View
    {
        $product = $catalog->product($slug) ?? abort(404);

        return view('pages.products.show', ['product' => $product]);
    }
}
