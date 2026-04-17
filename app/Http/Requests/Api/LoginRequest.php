<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'credential' => ['required', 'string'],
            'password' => ['sometimes', 'nullable', 'string'],
            'role' => ['sometimes', 'string', 'in:eleve,enseignant,parent,administrateur,user'],
            'remember' => ['boolean'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'credential.required' => 'Identifiant (Email ou Matricule) requis.',
            'password.required' => 'Mot de passe requis.',
        ];
    }
}
