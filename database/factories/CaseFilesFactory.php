<?php

namespace Database\Factories;

use App\Models\CaseFiles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseFiles>
 */
class CaseFilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filename' => $this->faker->uuid().'.pdf',
            'uploaded_by' => $this->faker->name(),
        ];
    }
}
