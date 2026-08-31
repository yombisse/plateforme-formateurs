<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_complet' => ['required', 'string', 'max:255'],
            'telephone' => [
                'required',
                'string',
                'regex:/^[\+]?[0-9\s\-\(\)]{8,15}$/',
                Rule::unique('inscriptions')->where(function ($query) {
                    return $query->where('formation_id', $this->route('formation')->id);
                }),
            ],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom_complet.required' => 'Le nom complet est requis.',
            'nom_complet.max' => 'Le nom complet ne doit pas dépasser 255 caractères.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'telephone.regex' => 'Le format du numéro de téléphone est invalide.',
            'telephone.unique' => 'Ce numéro est déjà inscrit à cette formation.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
        ];
    }
}
