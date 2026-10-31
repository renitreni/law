<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_returns_200()
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
    }

    public function test_about_page_returns_200()
    {
        $response = $this->get('/en/about');

        $response->assertStatus(200);
    }

    public function test_attorneys_page_returns_200()
    {
        $response = $this->get('/en/attorneys');

        $response->assertStatus(200);
    }

    public function test_services_page_returns_200()
    {
        $response = $this->get('/en/list-services');

        $response->assertStatus(200);
    }

    public function test_gallery_page_returns_200()
    {
        $response = $this->get('/en/gallery');

        $response->assertStatus(200);
    }

    public function test_contact_page_returns_200()
    {
        $response = $this->get('/en/contact');

        $response->assertStatus(200);
    }

    public function test_inquire_page_returns_200()
    {
        $response = $this->get('/en/inquire');

        $response->assertStatus(200);
    }

    public function test_service_detail_page_returns_200()
    {
        $response = $this->get('/en/list-services/civil-litigation');

        $response->assertStatus(200);
    }

    public function test_root_redirects_to_welcome()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('welcome', ['lang' => 'en']));
    }
}