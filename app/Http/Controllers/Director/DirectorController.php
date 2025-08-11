<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Director;
use App\Models\ResetCodePasswordDirector;
use App\Notifications\SendEmailToDirectorAfterRegistrationNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DirectorController extends Controller
{
    public function create(){
        $directors = Director::all();
        return view('hopital.director.create', compact('directors'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:directors,email',
        ],[
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        ]);
        try {
            // Récupérer le docteur connecté
            $hopital = auth('hopital')->user();	
        
            if (!$hopital || !$hopital->nomHop || !$hopital->commune) {
                return redirect()->back()->withErrors(['error' => 'Impossible de récupérer le nom de l\'hôpital.']);
            }
        
            // Création du sous-admin
            $director = new Director();
            $director->name = $request->name;
            $director->prenom = $request->prenom;
            $director->email = $request->email;
            $director->password = Hash::make('default');
            $director->contact = $request->contact;
            $director->profile_picture = $request->profile_picture;
            $director->nomHop = $hopital->nomHop; // Associe le même nomHop que le docteur
            $director->commune = $hopital->commune; // Associe la commune du docteur
            $director->save();
        
            // Envoi de l'e-mail de vérification
            if ($director) {
                try {
                    ResetCodePasswordDirector::where('email', $director->email)->delete();
                    $code = rand(1000, 4000);
        
                    $data = [
                        'code' => $code,
                        'email' => $director->email,
                    ];
        
                    ResetCodePasswordDirector::create($data);
        
                    Notification::route('mail', $director->email)
                        ->notify(new SendEmailToDirectorAfterRegistrationNotification($code, $director->email));
        
                    return redirect()->route('directeur.create')
                        ->with('success', 'Le directeur a été ajouté avec succès.');
                } catch (Exception $e) {
                    Log::error('Erreur création directeur: ' . $e->getMessage());
                    throw new Exception('Une erreur est survenue lors de l\'envoi de l\'e-mail.');
                }
            }
        } catch (Exception $e) {
            Log::error('Erreur création directeur: ' . $e->getMessage());
            throw new Exception('Une erreur est survenue lors de la création du sous-admin.');
        }
    }

    public function edit(Director $director){
        return view('hopital.director.edit', compact('director'));
    }

    public function update(UpdateDoctorRequest $request,Director $director){
        try {
            $director->name = $request->name;
            $director->prenom = $request->prenom;
            $director->email = $request->email;
            $director->contact = $request->contact;
            $director->update();
            return redirect()->route('directeur.create')->with('success','Vos informations ont été mises à jour avec succès.');
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('error','Une erreur est survenue lors de la modification du director');
        }
    }
}
