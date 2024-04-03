<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function service(string $service): View
    {
        $json = json_decode(file_get_contents(public_path('json/services.json'), false));
        $data = $json->$service;

        return view('service', ['service' => $data]);
    }
}
