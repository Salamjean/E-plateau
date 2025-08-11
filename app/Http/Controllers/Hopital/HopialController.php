<?php

namespace App\Http\Controllers\Hopital;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Doctor;
use App\Models\Hopital;
use App\Models\ResetCodePasswordHop;
use App\Notifications\SendEmailToHopitalAfterRegistrationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class HopialController extends Controller
{
    public function dashboard(Request $request)
    {
        // Récupérer le sousadmin connecté
        $sousadmin = auth('hopital')->user();

        // Récupérer les détails du sousadmin
        $sousadminDetails = Doctor::find($sousadmin->id);

        // Récupérer le mois et l'année sélectionnés, ou la date actuelle par défaut
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Compter le total des déclarations pour le mois sélectionné
        $communeAdmin = $sousadmin->nomHop;
        $docteur = Doctor::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        $naisshop = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        $deceshop = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();

        // Récupérer les données pour les graphiques (Naissances)
        $naissData = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')->toArray();

        // Remplir les données manquantes pour les naissances
        $naissData = array_replace(array_fill(1, 12, 0), $naissData);

        // Calculer le total des déclarations
        $total = $naisshop + $deceshop;

        // Récupérer les données pour les graphiques (Décès)
        $decesData = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')->toArray();

        // Remplir les données manquantes pour les décès
        $decesData = array_replace(array_fill(1, 12, 0), $decesData);

        // Passer les données à la vue

        return view('hopital.dashboard', compact(
            'sousadminDetails',
            'naisshop',
            'deceshop',
            'docteur',
            'total',
            'selectedMonth',
            'selectedYear',
            'naissData',
            'decesData'
        ));
    }

    public function create(){
        return view('mairie.hopital.create');
    }

    public function index(){
        $hopital = Hopital::get();
        return view('mairie.hopital.index', compact('hopital'));
    }
    


    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hopitals,email',
            'contact' => 'required|string|min:10',
            'nomHop' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        
        ],[
            'commune.max' => 'La commune ne doit pas dépasser 255 caractères.',
            'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'contact.required' => 'Le numéro de contact est requis.',
            'contact.string' => 'Le numéro de contact doit être une chaîne de caractères.',
            'contact.min' => 'Le numéro de contact doit contenir au moins 10 chiffres.',
            'nomHop.required' => 'Le nom du hopital est requis.',
            'nomHop.string' => 'Le nom du hopital doit être une chaîne de caractères.',
            'nomHop.max' => 'Le nom du hopital ne doit pas dépasser 255 caractères.',
            'commune.required' => 'La commune est requise.',
            'commune.string' => 'La commune doit être une chaîne de caractères.',
            'type.required' => 'Le type est requis.',
            'type.string' => 'Le type doit être une chaîne de caractères.',
            'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
        ]);

        try {
            // Récupérer le vendor connecté
            $mairie = Auth::guard('mairie')->user();

            if (!$mairie) {
                return redirect()->back()->withErrors(['error' => 'Impossible de récupérer les informations du vendor.']);
            }

            // Création du docteur
            $hopital = new Hopital();
            $hopital->name = $request->name;
            $hopital->email = $request->email;
            $hopital->contact = $request->contact;
            $hopital->password = Hash::make('default');
            
            if ($request->hasFile('profile_picture')) {
                $hopital->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            $hopital->nomHop = $request->nomHop;
            $hopital->commune = $request->commune;
            $hopital->type = $request->type;
            $hopital->save();

            // Envoi de l'e-mail de vérification
            ResetCodePasswordHop::where('email', $hopital->email)->delete();
            $code = rand(10000, 40000);

            ResetCodePasswordHop::create([
                'code' => $code,
                'email' => $hopital->email,
            ]);

            Notification::route('mail', $hopital->email)
                ->notify(new SendEmailToHopitalAfterRegistrationNotification($code, $hopital->email));

            return redirect()->route('hopital.index')
                ->with('success', 'Hôpital enregistré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    public function logout(){
        Auth::guard('hopital')->logout();
        return redirect()->route('hopital.login');
    }
}
