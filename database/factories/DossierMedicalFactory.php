<?php

namespace Database\Factories;

use App\Models\DossierMedical;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DossierMedical>
 */
class DossierMedicalFactory extends Factory
{
    protected $model = DossierMedical::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => 'DM-' . now()->format('Y') . '-' . strtoupper(fake()->bothify('??###?')),
            'description' => fake()->paragraph(),
            'patient_id' => fake()->numberBetween(1, 2000),
        ];
    }
}
