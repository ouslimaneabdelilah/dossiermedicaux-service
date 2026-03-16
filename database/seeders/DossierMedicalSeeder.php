<?php

namespace Database\Seeders;

use App\Models\DossierMedical;
use App\Models\DossierMedicalMaladie;
use Illuminate\Database\Seeder;

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
                $maladieIds = collect(range(1, fake()->numberBetween(1, 4)))
                    ->map(fn (): int => fake()->numberBetween(1, 50))
                    ->unique();

                foreach ($maladieIds as $maladieId) {
                    DossierMedicalMaladie::create([
                        'dossier_medical_id' => $dossier->id,
                        'maladie_id' => $maladieId,
                    ]);
                }
            });
    }
}
