<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\Director;
use App\Models\ResetCodePasswordDirector;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthenticateDirector extends Controller
{
    public function defineAccess($email){
        //Vérification si le sous-admin existe déjà
        $checkSousadminExiste = Director::where('email', $email)->first();

        if($checkSousadminExiste){
            return view('director.auth.defineAccess', compact('email'));
        }else{
            return redirect()->route('directeur.login');
        };
    }

    public function submitDefineAccess(Request $request){

        // Validation des données
        $request->validate([
                'code'=>'required|exists:reset_code_password_directors,code',
                'password' => 'required|same:confirme_password',
                'confirme_password' => 'required|same:password',
                
            ], [
                'code.exists' => 'Le code de réinitialisation est invalide.',
                'code.required' => 'Le code de réinitialisation est obligatoire verifié votre mail.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.same' => 'Les mots de passe doivent être identiques.',
                'confirme_password.same' => 'Les mots de passe doivent être identiques.',
                'confirme_password.required' => 'Le mot de passe de confirmation est obligatoire.',
            
        ]);
        try {
            $director = Director::where('email', $request->email)->first();

            if ($director) {
                // Mise à jour du mot de passe
                $director->password = Hash::make($request->password);

                // Vérifier si une image est uploadée
                if ($request->hasFile('profile_picture')) {
                    // Supprimer l'ancienne photo si elle existe
                    if ($director->profile_picture) {
                        Storage::delete('public/' . $director->profile_picture);
                    }

                    // Stocker la nouvelle image
                    $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                    $director->profile_picture = $imagePath;
                }
                $director->update();

                if($director){
                $existingcodedirector =  ResetCodePasswordDirector::where('email', $director->email)->count();

                if($existingcodedirector > 1){
                    ResetCodePasswordDirector::where('email', $director->email)->delete();
                }
                }

                return redirect()->route('directeur.login')->with('success', 'Compte mis à jour avec succès');
            } else {
                return redirect()->route('directeur.login')->with('error', 'Email inconnu');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function login(){
         if (auth('director')->check()) {
            return redirect()->route('directeur.dashboard');
        }
        return view('director.auth.login');
    }

    public function handleLogin(Request $request)
    {
        
        $request->validate([
            'email' =>'required|exists:directors,email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Le mail est obligatoire.',
            'email.exists' => 'Cette adresse mail n\'existe pas.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
        ]);
        try {
            if(auth('director')->attempt($request->only('email', 'password')))
            {
                return redirect()->route('directeur.dashboard')->with('Bienvenu sur votre page ');
            }else{
                return redirect()->back()->with('error', 'Votre mot de passe est incorrect.');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
