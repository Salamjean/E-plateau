<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\ResetCodePasswordFinance;
use App\Notifications\SendEmailToFinanceAfterRegistrationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use PDF;

class FinanceController extends Controller
{
    public function index()
    {
        $caisse = Auth::guard('caisse')->user();
        $agents = Finance::whereNull('archived_at')
            ->where('communeM', $caisse->communeM)
            ->with('timbres') 
            ->paginate(10);

        return view('caisse.finance.index', compact('agents'));
    }

    public function create(){
        return view('caisse.finance.create');
    }

    public function store(Request $request){
        // Validation des données
        $request->validate([
           'name' => 'required|string|max:255',
           'prenom' => 'required|string|max:255',
           'email' => 'required|email|unique:livreurs,email',
           'contact' => 'required|string|min:10',
           'commune' => 'required|string|max:255',
           'cas_urgence' => 'required|string|max:255',
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
            'cas_urgence.required' => 'La personne à contacter est obligatoire.',
            'profile_picture.image' => 'Le fichier doit être une image.',
            'profile_picture.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou svg.',
            'profile_picture.max' => 'L\'image ne doit pas dépasser 2048 KB.',
       
       ]);
   
       try {
           // Récupérer le mairie connecté
           $caisse = Auth::guard('caisse')->user();
   
           if (!$caisse || !$caisse->name) {
               return redirect()->back()->withErrors(['error' => 'Impossible de récupérer les informations du poste.']);
           }
   
           // Création du finance
           $finance = new Finance();
           $finance->name = $request->name;
           $finance->prenom = $request->prenom;
           $finance->email = $request->email;
           $finance->contact = $request->contact;
           $finance->cas_urgence = $request->cas_urgence;
           $finance->password = Hash::make('default');
           
           if ($request->hasFile('profile_picture')) {
               $finance->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
           }
   
           $finance->commune = $request->commune;
           $finance->communeM = $caisse->communeM;
           
           $finance->save();
   
           // Envoi de l'e-mail de vérification
           ResetCodePasswordFinance::where('email', $finance->email)->delete();
           $code1 = rand(1000, 4000);
           $code = $code1.''.$finance->id;
   
           ResetCodePasswordFinance::create([
               'code' => $code,
               'email' => $finance->email,
           ]);
   
           Notification::route('mail', $finance->email)
               ->notify(new SendEmailToFinanceAfterRegistrationNotification($code, $finance->email));
   
           return redirect()->route('finance.index')->with('success', 'Le financier a bien été enregistré avec succès.');
       } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
       }
    }

    public function exportPdf($id)
    {
        $agent = Finance::with(['timbres' => function($query) {
            $query->whereYear('created_at', now()->year);
        }])->findOrFail($id);
        
        // Calculer les totaux par mois
        $monthlyData = [];
        $currentYear = now()->year;
        
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create($currentYear, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth();
            
            $timbres = $agent->timbres->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            $totalTimbres = $timbres->sum('nombre_timbre');
            
            $monthlyData[] = [
                'month' => $startOfMonth->locale('fr')->monthName,
                'year' => $currentYear,
                'timbres' => $totalTimbres,
                'montant' => $totalTimbres * 500
            ];
        }
        
        $totalAnnualTimbres = $agent->timbres->sum('nombre_timbre');
        $totalAnnualAmount = $totalAnnualTimbres * 500;
        
        $pdf = PDF::loadView('caisse.finance.rapport-pdf', [
            'agent' => $agent,
            'monthlyData' => $monthlyData,
            'totalTimbres' => $totalAnnualTimbres,
            'totalAmount' => $totalAnnualAmount,
            'currentYear' => $currentYear
        ]);
        
        return $pdf->download('rapport_financier_' . $agent->name . '_' . $agent->prenom . '_' . $currentYear . '.pdf');
    }
}
