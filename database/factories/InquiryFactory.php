<?php

namespace Database\Factories;

use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
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
