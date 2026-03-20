<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDossierMedicalRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|min:20',
            'patient_id'  => 'required|int',
            'maladie_ids' => 'required|array|min:1',
            'maladie_ids.*' => 'int',
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'La description du dossier médical est obligatoire.',
            'description.min'      => 'La description doit contenir au moins 20 caractères.',
            'patient_id.required'  => "L'identifiant du patient est requis.",
            'patient_id.int'      => "L'identifiant du patient doit être un int valide.",
            'maladie_ids.required' => 'Veuillez associer au moins une maladie à ce dossier.',
        ];
    }
}
