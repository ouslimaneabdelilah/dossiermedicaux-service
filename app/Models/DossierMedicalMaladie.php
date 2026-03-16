<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedicalMaladie extends Model
{
    use HasFactory;
    protected $fillable = [
        'dossier_medical_id',
        'maladie_id',
    ];

}
