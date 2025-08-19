<?php

namespace App\Http\Controllers\Poste;

use App\Http\Controllers\Controller;
use App\Models\Poste;
use App\Models\ResetCodePasswordPoste;
use App\Notifications\SendEmailToPosteAfterRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class PosteController extends Controller
{
    public function index(){
        $postes = Poste::get();
        return view('mairie.poste.index', compact('postes'));
    }

    public function create(){
        return view('mairie.poste.create');
    }

     public function store(Request $request){
        // Validation des données
        $request->validate([
           'name' => 'required|string|max:255',
           'prenom' => 'required|string|max:255',
           'email' => 'required|email|unique:postes,email',
           'contact' => 'required|string|min:10',
           'commune' => 'required|string|max:255',
           'profile_picture' => 'nullable|image|max:2048',

        ],[
            'name.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'email.unique' => 'Cette adresse e-mail est déjà associée à un compte.',
            'contact.required' => 'Le contact est obligatoire.',
            'contact.min' => 'Le contact doit avoir au moins 10 chiffres.',
            'commune.required' => 'La commune est obligatoire.',
            'profile_picture.image' => 'Le fichier doit être une image.',
            'profile_picture.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou svg.',
            'profile_picture.max' => 'L\'image ne doit pas dépasser 2048 KB.',
       
       ]);
   
       try {
           // Récupérer le mairie connecté
           $mairie = Auth::guard('mairie')->user();
   
           if (!$mairie || !$mairie->name) {
               return redirect()->back()->withErrors(['error' => 'Impossible de récupérer les informations du mairie.']);
           }
   
           // Création du docteur
           $poste = new Poste();
           $poste->name = $request->name;
           $poste->prenom = $request->prenom;
           $poste->email = $request->email;
           $poste->contact = $request->contact;
           $poste->password = Hash::make('default');
           
           if ($request->hasFile('profile_picture')) {
               $poste->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
           }
   
           $poste->commune = $request->commune;
           $poste->communeM = $mairie->name;
           
           $poste->save();
   
           // Envoi de l'e-mail de vérification
           ResetCodePasswordPoste::where('email', $poste->email)->delete();
           $code1 = rand(1000, 4000);
           $code = $code1.''.$poste->id;
   
           ResetCodePasswordPoste::create([
               'code' => $code,
               'email' => $poste->email,
           ]);
   
           Notification::route('mail', $poste->email)
               ->notify(new SendEmailToPosteAfterRegistrationNotification($code, $poste->email));
   
           return redirect()->route('post.index')->with('success', 'La poste a bien été enregistré avec succès.');
       } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
       }
    }
}
