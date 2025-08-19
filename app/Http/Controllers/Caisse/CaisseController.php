<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\ResetCodePasswordCaisse;
use App\Notifications\SendEmailToCaisseAfterRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Mockery\Matcher\HasKey;

class CaisseController extends Controller
{

    public function index(){
        $admin = Auth::guard('mairie')->user();
        $caisses = Caisse::whereNull('archived_at')
            ->where('communeM', $admin->name)
            ->paginate(10);

        return view('mairie.caisse.index', compact('caisses'));
    }

    public function create(){
        return view('mairie.caisse.create');
    }

     public function store(Request $request){
        // Validation des données
        $request->validate([
           'name' => 'required|string|max:255',
           'prenom' => 'required|string|max:255',
           'email' => 'required|email|unique:caisses,email',
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
           $caisse = new Caisse();
           $caisse->name = $request->name;
           $caisse->prenom = $request->prenom;
           $caisse->email = $request->email;
           $caisse->contact = $request->contact;
           $caisse->password = Hash::make('default');
           
           if ($request->hasFile('profile_picture')) {
               $caisse->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
           }
   
           $caisse->commune = $request->commune;
           $caisse->communeM = $mairie->name;
           
           $caisse->save();
   
           // Envoi de l'e-mail de vérification
           ResetCodePasswordCaisse::where('email', $caisse->email)->delete();
           $code1 = rand(10000, 40000);
           $code = $code1.''.$caisse->id;
   
           ResetCodePasswordCaisse::create([
               'code' => $code,
               'email' => $caisse->email,
           ]);
   
           Notification::route('mail', $caisse->email)
               ->notify(new SendEmailToCaisseAfterRegistrationNotification($code, $caisse->email));
   
           return redirect()->route('caisse.index')->with('success', 'Agent financier enregistré avec succès.');
       } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
       }
    }

     
}
