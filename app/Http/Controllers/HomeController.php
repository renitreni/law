<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{

    public function index(string $lang) : View
    {
        App::setLocale($lang);
        return view('welcome')->with('lang',$lang);
    }

    public function about(string $lang) : View
    {
        App::setLocale($lang);
        return view('about')->with('lang',$lang);
    }

    public function attorneys(string $lang) : View
    {
        App::setLocale($lang);
        return view('attorneys')->with('lang',$lang);
    }

    public function services(string $lang) : View
    {
        App::setLocale($lang);
        return view('services')->with('lang',$lang);
    }

    public function gallery(string $lang) : View
    {
        App::setLocale($lang);
        return view('gallery')->with('lang',$lang);
    }

    public function contact(string $lang) : View
    {
        App::setLocale($lang);
        return view('contact')->with('lang',$lang);
    }

    public function inquire(string $lang) : View
    {
        App::setLocale($lang);
        return view('inquire')->with('lang',$lang);
    }

    public function service(string $lang, string $service) : View
    {
        App::setLocale($lang);
        $json = json_decode(file_get_contents(public_path('json/services.json'),false));
        $data = $json->$service;
        return view('service',['lang'=>$lang ,'service'=>$data]);
    }
}
