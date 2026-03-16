<?php

namespace Database\Seeders;

use App\Models\DossierMedical;
use App\Models\DossierMedicalMaladie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DossierMedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DossierMedical::factory()
            ->count(25)
            ->create()
            ->each(function (DossierMedical $dossier): void {
                $nombreDeMaladies = fake()->numberBetween(1, 4);
                  for ($i = 0; $i < $nombreDeMaladies; $i++) {
                    DossierMedicalMaladie::create([
                        'dossier_medical_id' => $dossier->id,
                        'maladie_id'         => fake()->numberBetween(1, 2000),
                    ]);
                }
            });
    }
}
