<?php

namespace App\Http\Controllers\Hopital;

use App\Http\Controllers\Controller;
use App\Models\Hopital;
use App\Models\ResetCodePasswordHop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthenticateHopial extends Controller
{
     public function defineAccess($email){
        //Vérification si le sous-admin existe déjà
        $checkSousadminExiste = Hopital::where('email', $email)->first();

        if($checkSousadminExiste){
            return view('hopital.auth.defineAcces', compact('email'));
        }else{
            return redirect()->route('hopital.login');
        };
    }


    public function submitDefineAccess(Request $request){

        // Validation des données
        $request->validate([
                'code'=>'required|exists:reset_code_password_hops,code',
                'password' => 'required|same:confirme_password',
                'confirme_password' => 'required|same:password',
            ], [
                'code.required' => 'Le code de réinitialisation est obligatoire.', 
                'code.exists' => 'Le code de réinitialisation est invalide.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.same' => 'Les mots de passe doivent être identiques.',
                'confirme_password.required' => 'Le mot de passe de confirmation est obligatoire.',
                'confirme_password.same' => 'Les mots de passe doivent être identiques.',
            
        ]);
        try {
            $hopital = Hopital::where('email', $request->email)->first();

            if ($hopital) {
                // Mise à jour du mot de passe
                $hopital->password = Hash::make($request->password);

                // Vérifier si une image est uploadée
                if ($request->hasFile('profile_picture')) {
                    // Supprimer l'ancienne photo si elle existe
                    if ($hopital->profile_picture) {
                        Storage::delete('public/' . $hopital->profile_picture);
                    }

                    // Stocker la nouvelle image
                    $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                    $hopital->profile_picture = $imagePath;
                }
                $hopital->update();

                if($hopital){
                $existingcodehop =  ResetCodePasswordHop::where('email', $hopital->email)->count();

                if($existingcodehop > 1){
                    ResetCodePasswordHop::where('email', $hopital->email)->delete();
                }
                }

                return redirect()->route('hopital.login')->with('success', 'Vos Accès  on été definir avec succès');
            } else {
                return redirect()->route('hopital.login')->with('error', 'Email inconnu');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

     public function login(){
        return view('hopital.auth.login');
    }

    public function handleLogin(Request $request)
    {
        
        $request->validate([
            'email' =>'required|exists:hopitals,email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Le mail est obligatoire.',
            'email.exists' => 'Cette adresse mail n\'existe pas.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
        ]);

        try {
            if(auth('hopital')->attempt($request->only('email', 'password')))
            {
                return redirect()->route('hopital.dashboard')->with('Bienvenu sur votre page');
            }else{
                return redirect()->back()->with('error', 'Votre mot de passe est incorrect.');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }


    
}
