<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Entry;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
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
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@hoopelink.com',
        ]);
        User::factory()->create([
            'name' => "Maha Aljubaire",
            'email' => 'atty.mahaaljubaire@mesharialhumlaw.com',
            'password' => Hash::make('Atty_mahaaljubaire_rb')
        ]);
        if (app()->environment(['local', 'staging'])) {
            Matter::factory()
                ->count(10)
                ->has(
                    SubMatter::factory()
                        ->count(5)
                        ->state(function (array $attributes, Matter $matter) {
                            return ['matter_id' => $matter->id];
                        })
                )->create();

            Client::factory()->count(10)->create();
            Office::factory()->count(10)->create();
            Entry::factory()->count(800)->create();
        }
    }
}
