<?php
namespace App\Services;

use App\Models\DossierMedical;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DossierMedicalServices{
    // public function __construct(protected RabbitMQService $mq) {}
    public function store(array $data): DossierMedical
    {
        return DB::transaction(function () use ($data) {
            $dossier = DossierMedical::create([
                'matricule'   => 'DM-' . date('Y') . '-' . strtoupper(Str::random(6)),
                'description' => $data['description'],
                'patient_id'  => $data['patient_id'],
            ]);
            if (isset($data['maladie_ids'])) {
                $dossier->maladies()->delete();
                $maladies = array_map(fn($id) => ['maladie_id' => $id], $data['maladie_ids']);
                $dossier->maladies()->createMany($maladies);
            }
            return $dossier;
        });
    }

    public function update(string $uuid, array $data): DossierMedical
    {
        return DB::transaction(function () use ($uuid, $data) {
            $dossier = DossierMedical::findOrFail($uuid);
            $dossier->update($data);
            if (isset($data['maladie_ids'])) {
                $dossier->maladies()->delete();
                $maladies = array_map(fn($id) => ['maladie_id' => $id], $data['maladie_ids']);
                $dossier->maladies()->createMany($maladies);
            }
            return $dossier;
        });
    }

    public function generatePdf(DossierMedical $dossier)
    {
        $dossier->load('maladies');
        $pdf = Pdf::loadView('pdf.report', compact('dossier'));
        return $pdf->download('rapport-patient-' . $dossier->matricule . '.pdf');
    }

    public function delete(string $uuid): void
    {
        $dossier = DossierMedical::findOrFail($uuid);
        $dossier->delete();
        // $this->mq->publish('dossier_events', ['event' => 'DELETED', 'id' => $uuid]);
    }

    public function deleteByPatientUuid(string $patientUuid): void
    {
        DB::transaction(function () use ($patientUuid) {
            DossierMedical::where('patient_id', $patientUuid)->delete();
        });
    }
}