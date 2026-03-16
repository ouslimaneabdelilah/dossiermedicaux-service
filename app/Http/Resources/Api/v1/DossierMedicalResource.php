<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DossierMedicalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'matricule'   => $this->matricule,
            'description' => $this->description,
            'patient_id'  => $this->patient_id,
            'maladie_ids' => $this->whenLoaded('maladies', fn () => $this->maladies->pluck('maladie_id')),
            'created_at'  => $this->created_at?->toISOString(),
            'updated_at'  => $this->updated_at?->toISOString(),
        ];
    }
}
