<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDossierMedicalRequest extends FormRequest
{
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
            'description' => 'sometimes|string|min:20',
            'maladie_ids' => 'sometimes|array',
            'maladie_ids.*' => 'uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'description.min' => 'La description doit être plus détaillée (20 chars min).',
            'maladie_ids.array' => 'Le format des maladies est invalide.',
        ];
    }
}
