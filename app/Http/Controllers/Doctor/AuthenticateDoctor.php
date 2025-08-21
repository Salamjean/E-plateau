<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ResetCodePassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthenticateDoctor extends Controller
{
    public function defineAccess($email){
        //Vérification si le sous-admin existe déjà
        $checkdoctorExiste = Doctor::where('email', $email)->first();

        if($checkdoctorExiste){
            return view('doctor.auth.defineAccess', compact('email'));
        }else{
            return redirect()->route('doctor.login');
        };
    }

    public function submitDefineAccess(Request $request){
        $request->validate([
                'code'=>'required|exists:reset_code_passwords,code',
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
            
            $doctor = Doctor::where('email', $request->email)->first();

            if ($doctor) {
                // Mise à jour du mot de passe
                $doctor->password = Hash::make($request->password);

                // Vérifier si une image est uploadée
                if ($request->hasFile('profile_picture')) {
                    // Supprimer l'ancienne photo si elle existe
                    if ($doctor->profile_picture) {
                        Storage::delete('public/' . $doctor->profile_picture);
                    }

                    // Stocker la nouvelle image
                    $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                    $doctor->profile_picture = $imagePath;
                }
                $doctor->update();

                if($doctor){
                $existingcode =  ResetCodePassword::where('email', $doctor->email)->count();

                if($existingcode > 1){
                    ResetCodePassword::where('email', $doctor->email)->delete();
                }
                }

                return redirect()->route('doctor.login')->with('success', 'Compte mis à jour avec succès');
            } else {
                return redirect()->route('doctor.login')->with('error', 'Email inconnu');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }


     public function login(){
        if (auth('doctor')->check()) {
            return redirect()->route('doctor.dashboard');
        }
        Auth::guard('doctor')->logout();
        return view('doctor.auth.login');
    }

    public function handleLogin(Request $request)
    {
        // Validation des champs du formulaire
        $request->validate([
            'email' => 'required|exists:doctors,email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Le mail est obligatoire.',
            'email.exists' => 'Cette adresse mail n\'existe pas.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
        ]);

        try {
            // Récupérer le sous-administrateur par son email
            $doctor = Doctor::where('email', $request->email)->first();

            // Vérifier si le sous-administrateur est archivé
            if ($doctor && $doctor->archived_at !== null) {
                return redirect()->back()->with('error', 'Votre compte a été supprimé. Vous ne pouvez pas vous connecter.');
            }

            // Tenter la connexion
            if (auth('doctor')->attempt($request->only('email', 'password'))) {
                // Récupérer l'utilisateur authentifié
                $doctor = auth('doctor')->user();

                // Rediriger vers la page spécifique en fonction de l'ID
                return redirect()->route('doctor.dashboard')->with('success', 'Bienvenu sur votre page');
            } else {
                return redirect()->back()->with('error', 'Votre mot de passe est incorrect.');
            }
        } catch (Exception $e) {
            // Gérer les erreurs
            Log::error('Erreur de connexion', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la connexion.');
        }
    }
}
