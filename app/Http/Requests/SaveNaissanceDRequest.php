<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveNaissanceDRequest extends FormRequest
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
            'type' => 'required',
            'name' => 'required',
            'prenom' => 'required',
            'number' => 'required',
            'DateR' => 'required',
            'CMU' => 'nullable',
            'commune' => 'required',
            'CNI' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
            
        ];
    }

    public function messages() 
    {
        return [
            'type.required' => 'le type d\'extrait que vous-voulez demander est obligatoire',
            'name.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'number.required' => 'Le numéro de registre sur l\'extrait est obligatoire',
            'DateR.required' => 'La date de registre est obligatoire',
            'CMU.required' => 'Le numéro de CMU est obligatoire',
            'commune.required' => 'La commune est obligatoire',
            'CNI.required' => 'Le champ CNI est obligatoire',
            'CNI.mimes' => 'Le format du fichier doit être PNG, JPG, JPEG ou PDF',
            'CNI.max' => 'Le fichier ne doit pas dépasser 1Mo',
        ];
    }
}
