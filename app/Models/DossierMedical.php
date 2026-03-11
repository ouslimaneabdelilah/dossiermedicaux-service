<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DossierMedical extends Model
{
    /** @use HasFactory<\Database\Factories\Api\v1\DossierMedicalFactory> */
    use HasFactory,HasUuids;
    protected $fillable = [
        'matricule',
        'description',
        'patient_id',
    ];
    public function maladies():BelongsToMany
    {
       return $this->belongsToMany(
        DossierMedical::class,
        'dossier_medical_maladies', 
        'dossier_medical_id', 
        'maladie_id'
    );
    }
}
