<?php

namespace App\Http\Controllers;

use App\Content\Catalog;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(Catalog $catalog): View
    {
        return view('pages.services.index', ['services' => $catalog->services()]);
    }
}
