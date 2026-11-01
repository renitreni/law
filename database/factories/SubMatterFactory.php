<?php

namespace Database\Factories;

use App\Models\Matter;
use App\Models\SubMatter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<SubMatter>
 */
class SubMatterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'code' => Str::lower($this->faker->swiftBicNumber()),
            'matter_id' => Matter::factory(),
        ];
    }
}
