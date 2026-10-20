<?php

namespace App\Http\Controllers;

use App\Support\SiteContact;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.contact', ['contact' => SiteContact::fromConfig()]);
    }
}
