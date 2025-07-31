<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class MairieAuthenticate extends Controller
{
    public function login(){
        return view('mairie.auth.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' =>'required|exists:mairies,email',
            'password' => 'required|min:8',
        ], [
            
            
            'email.required' => 'Le mail est obligatoire.',
            'email.exists' => 'Cette adresse mail n\'existe pas.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min'=> 'Le mot de passe doit avoir au moins 8 caractères.',
        ]);

        try {
            if(auth('mairie')->attempt($request->only('email', 'password')))
            {
                return redirect()->route('mairie.dashboard')->with('Bienvenu sur votre page ');
            }else{
                return redirect()->back()->with('error', 'Votre mot de passe.');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
