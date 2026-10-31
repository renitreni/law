<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LawCase>
 */
class LawCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'case_plaintiff' => $this->faker->name(),
            'case_defendant' => $this->faker->name(),
            'case_description' => $this->faker->paragraph(),
            'case_category' => $this->faker->randomElement(['Civil', 'Criminal', 'Family', 'Corporate', 'Real Estate']),
            'case_status' => $this->faker->randomElement(['Open', 'In Progress', 'Closed', 'Pending']),
            'case_attorney' => $this->faker->name(),
            'case_date' => $this->faker->date(),
        ];
    }
}
