<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\CaseClient;
use App\Models\CaseCourt;
use App\Models\CaseFiles;
use App\Models\Client;
use App\Models\Entry;
use App\Models\Gallery;
use App\Models\Inquiry;
use App\Models\Invoice;
use App\Models\InvoiceService;
use App\Models\LawCase;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 user accounts
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@yaramay.online',
            'password' => Hash::make('Admin_2026!'),
        ]);

        $attorney1 = User::factory()->create([
            'name' => 'Maha Aljubaire',
            'email' => 'atty.mahaaljubaire@yaramay.online',
            'password' => Hash::make('Atty_maha_2026!'),
        ]);

        $info = User::factory()->create([
            'name' => 'Info Desk',
            'email' => 'info@yaramay.online',
            'password' => Hash::make('Info_2026!'),
        ]);

        $attorney2 = User::factory()->create([
            'name' => 'John Attorney',
            'email' => 'john.attorney@yaramay.online',
            'password' => Hash::make('John_2026!'),
        ]);

        $clerk = User::factory()->create([
            'name' => 'Sarah Clerk',
            'email' => 'sarah.clerk@yaramay.online',
            'password' => Hash::make('Sarah_2026!'),
        ]);

        // Create matters with submatters
        $matters = Matter::factory()
            ->count(10)
            ->has(
                SubMatter::factory()
                    ->count(5)
                    ->state(function (array $attributes, Matter $matter) {
                        return ['matter_id' => $matter->id];
                    })
            )->create();

        // Create clients, offices
        $clients = Client::factory()->count(10)->create();
        $offices = Office::factory()->count(10)->create();

        // Create entries (timesheet data)
        Entry::factory()->count(800)->create();

        // Create law cases with related data
        $lawCases = LawCase::factory()->count(15)->create();

        foreach ($lawCases as $lawCase) {
            // Create case client
            CaseClient::factory()->create([
                'law_cases_id' => $lawCase->id,
            ]);

            // Create case courts (1-3 per case)
            CaseCourt::factory()
                ->count(rand(1, 3))
                ->create([
                    'law_cases_id' => $lawCase->id,
                ]);

            // Create case files (0-2 per case)
            CaseFiles::factory()
                ->count(rand(0, 2))
                ->create([
                    'law_cases_id' => $lawCase->id,
                    'uploaded_by' => fake()->randomElement([$admin->name, $attorney1->name, $attorney2->name]),
                ]);
        }

        // Create invoices with services
        $invoices = Invoice::factory()->count(10)->create();
        foreach ($invoices as $invoice) {
            InvoiceService::factory()
                ->count(rand(1, 5))
                ->create([
                    'invoice_id' => $invoice->id,
                ]);
        }

        // Create announcements for users
        foreach ([$admin, $attorney1, $info, $attorney2, $clerk] as $user) {
            Announcement::factory()
                ->count(rand(2, 5))
                ->create([
                    'user_id' => $user->id,
                ]);
        }

        // Create galleries
        Gallery::factory()->count(12)->create();

        // Create inquiries
        Inquiry::factory()->count(8)->create();
    }
}
