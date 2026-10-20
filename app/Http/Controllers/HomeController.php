<?php

namespace App\Http\Controllers;

use App\Content\Catalog;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(Catalog $catalog): View
    {
        return view('pages.home', [
            'products' => $catalog->featuredProducts(),
            'services' => $catalog->services(),
        ]);
    }
}
