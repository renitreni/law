<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use Carbon\Carbon;
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
        $office = Office::query()->inRandomOrder()->first();
        $isTemplate = $this->faker->numberBetween(0,1);

        $templateName = null;
        if($isTemplate) {
            $templateName = $this->faker->word();
        }

        return [
            "client_id" => $client->id,
            "matter_id" => $matter->id,
            "sub_matter_id" => $subMatter->id,
            "office_id" => $office->id,
            "entry_date" => Carbon::parse($this->faker->dateTimeBetween('-7 days'))->startOfDay(),
            "duration" => $this->faker->randomFloat(2, 0.1, 0.8),
            "narrative" => $this->faker->sentence(),
            "template_name" => $templateName,
            "is_template" => $isTemplate,
            "is_draft" => $this->faker->numberBetween(0,1),
            "is_billable" => $this->faker->numberBetween(0,1),
        ];
    }
}
