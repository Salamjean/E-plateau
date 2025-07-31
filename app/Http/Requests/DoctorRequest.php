<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'name' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'contact' => 'required|unique:doctors,contact',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email n\'est pas valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'contact.required' => 'Le contact est obligatoire',
            'contact.unique' => 'Ce contact est déjà utilisé',
        ];
    }
}
