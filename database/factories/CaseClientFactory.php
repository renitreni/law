<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseClient>
 */
class CaseClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name(),
            'client_contact' => $this->faker->phoneNumber(),
            'client_email' => $this->faker->unique()->safeEmail(),
            'client_company' => $this->faker->company(),
        ];
    }
}
