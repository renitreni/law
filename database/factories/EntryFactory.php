<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Entry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entry>
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
        return [
            'client_id' => Client::factory(),
            'matter_id' => Matter::factory(),
            'sub_matter_id' => SubMatter::factory(),
            'office_id' => Office::factory(),
            'entry_date' => Carbon::parse($this->faker->dateTimeBetween('-1 months', '+5 months'))->startOfDay(),
            'duration' => $this->faker->randomFloat(2, 0.1, 0.8),
            'narrative' => $this->faker->sentence(),
            'template_name' => $this->faker->optional()->word(),
            'is_template' => $this->faker->boolean(),
            'is_draft' => $this->faker->boolean(),
            'is_billable' => $this->faker->boolean(),
        ];
    }
}
