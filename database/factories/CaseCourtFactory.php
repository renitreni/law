<?php

namespace Database\Factories;

use App\Models\CaseCourt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseCourt>
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
            'court_name' => $this->faker->company().' Court',
            'court_date' => $this->faker->date(),
            'court_address' => $this->faker->address(),
        ];
    }
}
