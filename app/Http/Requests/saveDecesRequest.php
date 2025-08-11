<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveDecesRequest extends FormRequest
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
            'identiteDeclarant' =>'required|mimes:png,jpg,jpeg,pdf|max:1000',
            'acteMariage' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
            'deParLaLoi' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
            ];
    }

    public function messages() 
    {
        return [
            'identiteDeclarant.required' => 'La CNI du déclarant est obligatoire.',
            'identiteDeclarant.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'identiteDeclarant.max' => 'L\'image ne doit pas dépasser 1000 Ko.',
            'acteMariage.required' => 'Le certificat médical de décès est obligatoire.',
            'acteMariage.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'acteMariage.max' => 'Le fichier ne doit pas dépasser 1000 Ko.',
            'deParLaLoi.required' => 'Le document de par la loi de décès est obligatoire.',
            'deParLaLoi.mimes' => 'Le fichier doit être au format PNG, JPG,JPEG ou pdf.',
            'deParLaLoi.max' => 'Le fichier ne doit pas dépasser 1000 Ko.',
        ];
    }
}
