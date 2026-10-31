<?php

namespace Tests\Feature\Livewire;

use App\Livewire\InquiryLivewire;
use App\Models\Inquiry;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_loads_inquiry_and_sets_is_view()
    {
        $inquiry = Inquiry::factory()->create();

        Livewire::test(InquiryLivewire::class)
            ->call('view', $inquiry->id)
            ->assertSet('isView', true)
            ->assertSet('viewData.id', $inquiry->id);
    }

    public function test_close_resets_view_data()
    {
        $inquiry = Inquiry::factory()->create();

        Livewire::test(InquiryLivewire::class)
            ->set('isView', true)
            ->set('viewData', $inquiry)
            ->call('close')
            ->assertSet('isView', false)
            ->assertSet('viewData', null);
    }

    public function test_render_returns_view()
    {
        Livewire::test(InquiryLivewire::class)
            ->call('render')
            ->assertViewIs('livewire.inquiry-livewire');
    }
}