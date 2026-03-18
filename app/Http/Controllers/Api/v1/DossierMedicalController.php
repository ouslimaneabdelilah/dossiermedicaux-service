<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDossierMedicalRequest;
use App\Http\Requests\UpdateDossierMedicalRequest;
use App\Http\Resources\Api\v1\DossierMedicalResource;
use App\Models\DossierMedical;
use App\Services\DossierMedicalServices;
use App\Services\RabbitMQPublisherService;

class DossierMedicalController extends Controller
{
    public function __construct(protected DossierMedicalServices $service, private RabbitMQPublisherService $rabbitPublisherService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DossierMedicalResource::collection(
            DossierMedical::with('maladies')->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDossierMedicalRequest $request) {
        $dossier = $this->service->store($request->validated());
        return (new DossierMedicalResource($dossier->load('maladies')))
            ->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DossierMedical $dossierMedical)
    {
        return new DossierMedicalResource($dossierMedical->load('maladies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDossierMedicalRequest $request, DossierMedical $dossierMedical)
    {
        $dossier = $this->service->update($dossierMedical->id, $request->validated());
        return new DossierMedicalResource($dossier->load('maladies'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DossierMedical $dossierMedical)
    {
        $data = $dossierMedical->toArray();
        $this->service->delete($dossierMedical->id);
        $this->rabbitPublisherService->publish($data, 'folder.deleted');
        return response()->json(['message' => 'Dossier supprimé avec succès'], 200);
    }


    public function downloadPdf(DossierMedical $dossierMedical)
    {
        return $this->service->generatePdf($dossierMedical);
    }
}
