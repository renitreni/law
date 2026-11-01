<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'isSecure' => $request->isSecure(),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
            'url' => $request->url(),
            'fullUrl' => $request->fullUrl(),
            'headers' => [
                'x-forwarded-proto' => $request->header('X-Forwarded-Proto'),
                'x-forwarded-host' => $request->header('X-Forwarded-Host'),
                'x-forwarded-port' => $request->header('X-Forwarded-Port'),
                'host' => $request->header('Host'),
            ],
            'server' => [
                'HTTPS' => $_SERVER['HTTPS'] ?? 'not set',
                'SERVER_PORT' => $_SERVER['SERVER_PORT'] ?? 'not set',
                'HTTP_X_FORWARDED_PROTO' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'not set',
                'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'not set',
            ],
        ]);
    }
}