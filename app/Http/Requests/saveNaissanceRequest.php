<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveNaissanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'identiteDeclarant' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
           'cdnaiss' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
           'acteMariage' => 'mimes:png,jpg,jpeg,pdf|max:1000',
           'nom' => 'required',
           'lieuNaiss' => 'required',
           'prenom' => 'required',
           'nompere' => 'required',
           'prenompere' => 'required',
           'datepere' => 'required',

        ];
    }

    public function messages() 
    {
        return [
            'identiteDeclarant.required' => 'La CNI du père est obligatoire.',
            'identiteDeclarant.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'identiteDeclarant.max' => 'L\'image ne doit pas dépasser 1000 Ko.',
            'cdnaiss.required' => 'Le Certificat est obligatoire.',
            'cdnaiss.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'cdnaiss.max' => 'Le fichier ne doit pas dépasser 1000 Ko.',
            'acteMariage.required' => 'le recto/verso de CNI est obligatoire.',
            'acteMariage.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'acteMariage.max' => 'L\'image ne doit pas dépasser 1000 Ko.',
            'nom.required' => 'Le nom de l\'enfant est obligatoire.',
            'lieuNaiss.required' => 'La date de naissance est obligatoire et doit être celle(s) sur le CMN.',
            'prenom.required' => 'Le prénom de l\'enfant est obligatoire.',
            'nompere.required' => 'Le nom du père est obligatoire.',
            'prenompere.required' => 'Le prénom du père est obligatoire.',
            'datepere.required' => 'La date de naissance du père est obligatoire.',
        ];
    }
}
