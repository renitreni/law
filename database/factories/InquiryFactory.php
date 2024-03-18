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
            "firstname"=> fake()->firstName(),
            "lastname"=> fake()->lastName(),
            "email" => fake()->unique()->safeEmail(),
            "legalIssue"=>fake()->word(),
            "message"=>fake()->text()
        ];
    }
}
