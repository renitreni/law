<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phonenumber' => $this->faker->numerify('##########'),
            'legalIssue' => $this->faker->randomElement(['Civil', 'Criminal', 'Family', 'Corporate', 'Real Estate']),
            'message' => $this->faker->paragraph(),
        ];
    }
}