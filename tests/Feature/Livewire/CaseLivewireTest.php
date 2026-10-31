<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CaseLivewire;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaseLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_page_redirects_to_add_case_route()
    {
        Livewire::test(CaseLivewire::class)
            ->call('AddPage')
            ->assertRedirect(route('add_case'));
    }

    public function test_render_returns_view()
    {
        Livewire::test(CaseLivewire::class)
            ->call('render')
            ->assertViewIs('livewire.case-livewire');
    }
}