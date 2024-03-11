<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(?string $page = "/"): View
    {
        $goto = "";

        switch ($page) {
            case '/':
                $goto = view('welcome');
                break;
            case 'about':
                $goto = view('about');
                break;
            case 'attorneys':
                $goto = view('attorneys');
                break;
            case 'contact':
                $goto = view('contact');
                break;
            default:
                $goto = "404 page";
                break;
        }
        return $goto;
    }
}
