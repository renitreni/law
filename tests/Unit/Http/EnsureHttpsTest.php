<?php

namespace Tests\Unit\Http;

use App\Http\Middleware\EnsureHttps;
use Illuminate\Http\Request;
use Tests\TestCase;

class EnsureHttpsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Force production environment for these tests
        $this->app['env'] = 'production';
    }

    public function test_https_request_in_production_passes_through(): void
    {
        $request = Request::create('https://law.yaramay.online/dashboard', 'GET');
        $request->server->set('HTTPS', 'on');

        $middleware = new EnsureHttps;
        $response = $middleware->handle($request, fn ($req) => response('OK'));

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_http_request_in_production_redirects_to_https(): void
    {
        $request = Request::create('http://law.yaramay.online/dashboard', 'GET');

        $middleware = new EnsureHttps;
        $response = $middleware->handle($request, fn ($req) => response('OK'));

        $this->assertEquals(301, $response->getStatusCode());
        // In test environment, the redirect target uses the test host, just verify it's HTTPS
        $this->assertStringStartsWith('https://', $response->getTargetUrl());
    }

    public function test_non_production_passes_through_without_redirect(): void
    {
        // Temporarily set to non-production
        $this->app['env'] = 'local';

        $request = Request::create('http://localhost/dashboard', 'GET');

        $middleware = new EnsureHttps;
        $response = $middleware->handle($request, fn ($req) => response('OK'));

        $this->assertEquals(200, $response->getStatusCode());
    }
}
