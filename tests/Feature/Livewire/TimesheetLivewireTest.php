<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TimesheetLivewire;
use App\Models\Client;
use App\Models\Matter;
use App\Models\SubMatter;
use App\Models\Office;
use App\Models\Entry;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class TimesheetLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_mount_sets_default_view_filter()
    {
        Livewire::test(TimesheetLivewire::class)
            ->call('mount')
            ->assertSet('viewFilter.state', 'month')
            ->assertSet('viewFilter.month', now()->format('m'))
            ->assertSet('viewFilter.year', now()->format('Y'));
    }

    public function test_filter_updates_view_filter_and_dispatches_event()
    {
        Livewire::test(TimesheetLivewire::class)
            ->call('filter', [
                'state' => 'month',
                'month' => '06',
                'year' => '2024',
                'day' => '15',
                'range' => '2024-06-01#2024-06-30',
            ])
            ->assertSet('viewFilter.month', '06')
            ->assertSet('viewFilter.year', '2024')
            ->assertDispatched('changeCalendarView');
    }

    public function test_calendar_summary_dispatches_bind_calendar_summary()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-06-15',
            'is_billable' => true,
            'is_draft' => false,
        ]);

        Livewire::test(TimesheetLivewire::class)
            ->set('viewFilter', [
                'state' => 'month',
                'month' => '06',
                'year' => '2024',
                'range' => '2024-06-01#2024-06-30',
            ])
            ->call('calendarSummary')
            ->assertDispatched('bindCalendarSummary');
    }

    public function test_show_details_calls_entry_service()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-06-15',
        ]);

        Livewire::test(TimesheetLivewire::class)
            ->call('showDetails', '2024-06-15')
            ->assertSet('details.0.entry_date', '2024-06-15');
    }

    public function test_keyword_client_returns_matching_clients()
    {
        Client::factory()->create(['name' => 'Test Client', 'code' => 'TC001']);
        Client::factory()->create(['name' => 'Another Client', 'code' => 'AC001']);

        Livewire::test(TimesheetLivewire::class)
            ->call('keywordClient', 'Test')
            ->assertSet('clients.0.text', 'TC001 - Test Client');
    }

    public function test_keyword_matter_returns_matching_matters()
    {
        Matter::factory()->create(['name' => 'Test Matter', 'code' => 'TM001']);
        Matter::factory()->create(['name' => 'Another Matter', 'code' => 'AM001']);

        Livewire::test(TimesheetLivewire::class)
            ->call('keywordMatter', 'Test')
            ->assertSet('matter.0.text', 'TM001 - Test Matter');
    }

    public function test_keyword_sub_matter_returns_matching_sub_matters()
    {
        $matter = Matter::factory()->create();
        SubMatter::factory()->create(['matter_id' => $matter->id, 'name' => 'Test Sub', 'code' => 'TS001']);
        SubMatter::factory()->create(['matter_id' => $matter->id, 'name' => 'Another Sub', 'code' => 'AS001']);

        Livewire::test(TimesheetLivewire::class)
            ->set('timeEntry.matter_id', $matter->id)
            ->call('keywordSubMatter', 'Test')
            ->assertSet('subMatter.0.text', 'TS001 - Test Sub');
    }

    public function test_keyword_office_returns_matching_offices()
    {
        Office::factory()->create(['name' => 'Test Office', 'code' => 'TO001']);
        Office::factory()->create(['name' => 'Another Office', 'code' => 'AO001']);

        Livewire::test(TimesheetLivewire::class)
            ->call('keywordOffice', 'Test')
            ->assertSet('office.0.text', 'TO001 - Test Office');
    }

    public function test_keyword_template_returns_matching_templates()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'is_template' => true,
            'template_name' => 'Test Template',
        ]);

        Livewire::test(TimesheetLivewire::class)
            ->call('keywordTemplate', 'Test')
            ->assertSet('templates.0.text', 'Test Template');
    }
}