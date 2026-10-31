<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseCourt>
 */
class CaseCourtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'court_name' => $this->faker->company() . ' Court',
            'court_date' => $this->faker->date(),
            'court_address' => $this->faker->address(),
        ];
    }
}
