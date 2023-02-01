<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Matter;
use App\Models\SubMatter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $client = Client::query()->inRandomOrder()->first();
        $matter = Matter::query()->inRandomOrder()->first();
        $subMatter = SubMatter::query()
            ->where('matter_id', $matter->id)
            ->inRandomOrder()
            ->first();

        return [
            "client_id" => $client->id,
            "matter_id" => $matter->id,
            "sub_matter_id" => $subMatter->id,
        ];
    }
}
