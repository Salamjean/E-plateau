<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Caisse;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Doctor;
use App\Models\Hopital;
use App\Models\Mairie;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use App\Models\ResetCodePasswordMairie;
use App\Notifications\SendEmailToMairieAfterRegistrationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class MairieController extends Controller
{
    public function dashboard(Request $request){
    Carbon::setLocale('fr');
    // Récupérer l'admin connecté
    $admin = Auth::guard('mairie')->user();

    // Récupérer le mois et l'année sélectionnés pour les naissances, décès et mariages
    $selectedMonth = $request->input('month', date('m'));
    $selectedYear = $request->input('year', date('Y'));

    // Récupérer le mois et l'année sélectionnés pour les naisshops et deceshops
    $selectedMonthHops = $request->input('month_hops', date('m'));
    $selectedYearHops = $request->input('year_hops', date('Y'));

    // Récupérer les données associées à la commune de cet admin pour le mois sélectionné
    // Données pour naissances, décès, et mariages
    $naissances = NaissanceCertificat::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->orderBy('created_at', 'desc')
        ->get();

    $naissancesD = NaissanceSimple::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->orderBy('created_at', 'desc')
        ->get();

    $deces = DecesCertificat::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->orderBy('created_at', 'desc')
        ->get();
        
    $decesdeja = DecesSimple::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->orderBy('created_at', 'desc')
        ->get();
    $mariages = Mariage::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->orderBy('created_at', 'desc')
        ->get();

    // Données pour naisshops et deceshops
    $naisshops = DeclarationNaissance::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonthHops)
        ->whereYear('created_at', $selectedYearHops)
        ->orderBy('created_at', 'desc')
        ->get();

    $deceshops = DeclarationDeces::where('commune', $admin->name)
        ->whereMonth('created_at', $selectedMonthHops)
        ->whereYear('created_at', $selectedYearHops)
        ->orderBy('created_at', 'desc')
        ->get();

    // NOUVEAU: Récupérer les données mensuelles pour l'année sélectionnée
    $monthlyHospitalData = $this->getMonthlyHospitalData($admin->name, $selectedYearHops);

    // Calcul des données globales
    $totalData = $naissances->count() + $naissancesD->count() + $decesdeja->count() + $deces->count() + $mariages->count();
    $totalDataHops = $naisshops->count() + $deceshops->count();

    // Pourcentages
    $naissancePercentage = $totalData > 0 ? ($naissances->count() / $totalData) * 100 : 0;
    $naissanceDPercentage = $totalData > 0 ? ($naissancesD->count() / $totalData) * 100 : 0;
    $decesPercentage = $totalData > 0 ? ($deces->count() / $totalData) * 100 : 0;
    $decesdejaPercentage = $totalData > 0 ? ($decesdeja->count() / $totalData) * 100 : 0;
    $mariagePercentage = $totalData > 0 ? ($mariages->count() / $totalData) * 100 : 0;
    $naisshopPercentage = $totalDataHops > 0 ? ($naisshops->count() / $totalDataHops) * 100 : 0;
    $deceshopPercentage = $totalDataHops > 0 ? ($deceshops->count() / $totalDataHops) * 100 : 0;

    $NaissP = $naissancePercentage + $naissanceDPercentage;    
    $DecesP = $decesPercentage + $decesdejaPercentage;    
    $NaissHop = $naisshopPercentage + $deceshopPercentage; 

    // Données pour le tableau de bord
    $naissancedash = $naissances->count();
    $decesdash = $deces->count();
    $decesdejadash = $decesdeja->count();
    $mariagedash = $mariages->count();
    $naissanceDdash = $naissancesD->count();
    $naisshopsdash = $naisshops->count();
    $deceshopsdash = $deceshops->count();
    $Naiss = $naissancedash + $naissanceDdash;
    $Dece = $decesdash + $decesdejadash;
    $NaissHopTotal = $naisshopsdash + $deceshopsdash;

    // Récupération des données récentes (3 derniers éléments)
    $recentNaissances = $naissances->take(2);
    $recentNaissancesd = $naissancesD->take(2);
    $recentDeces = $deces->take(2);
    $recentDecesdeja = $decesdeja->take(2);
    $recentMariages = $mariages->take(2);
    $recentNaisshops = $naisshops->take(2);
    $recentDeceshops = $deceshops->take(2);

    // Retourne la vue avec les données
    return view('mairie.dashboard', compact(
        'naissancedash', 'naisshopsdash', 'deceshopsdash','decesdejadash', 
        'NaissHopTotal', 'decesdash', 'NaissP','DecesP', 'mariagedash', 
        'naissances', 'naissancesD', 'deces','decesdeja', 'mariages', 
        'totalDataHops', 'totalData', 'naissancePercentage', 
        'naissanceDPercentage', 'decesPercentage', 'mariagePercentage', 
        'naisshopPercentage', 'deceshopPercentage', 
        'recentNaissances', 'recentDeces', 'recentMariages', 
        'Naiss','Dece','recentDecesdeja', 'NaissHop', 
        'selectedMonth', 'selectedYear', 
        'selectedMonthHops', 'selectedYearHops','recentNaisshops', 
        'recentDeceshops','recentNaissancesd','naissanceDdash',
        'monthlyHospitalData' // NOUVEAU: Ajout des données mensuelles
    ));
}

// NOUVELLE MÉTHODE: Récupérer les données mensuelles pour les actes hospitaliers
private function getMonthlyHospitalData($commune, $year)
{
    $months = range(1, 12);
    $data = [
        'naissances' => [],
        'deces' => []
    ];
    
    foreach ($months as $month) {
        // Compter les naissances hospitalières par mois
        $data['naissances'][$month] = DeclarationNaissance::where('commune', $commune)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
            
        // Compter les décès hospitaliers par mois
        $data['deces'][$month] = DeclarationDeces::where('commune', $commune)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
    }
    
    return $data;
}

    public function logout(){
        Auth::guard('mairie')->logout();
        return redirect()->route('mairie.login');
    }


    public function index(Request $request)
    {
        // Récupérer uniquement les mairies non archivées
        $vendors = Mairie::whereNull('archived_at')->get();

        // Compter les agents par commune
        $agentsCountByCommune = Agent::select('communeM', DB::raw('count(*) as total'))
            ->groupBy('communeM')
            ->get();
        $agentsCount = [];
        foreach ($agentsCountByCommune as $item) {
            $agentsCount[$item->communeM] = $item->total;
        }

        // Compter les caisses par commune
        $caisseCountByCommune = Caisse::select('communeM', DB::raw('count(*) as total'))
            ->groupBy('communeM')
            ->get();
        $caisseCount = [];
        foreach ($caisseCountByCommune as $item) {
            $caisseCount[$item->communeM] = $item->total;
        }

        // Compter les hôpitaux par commune
        $doctorCountByCommune = Hopital::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $doctorCount = [];
        foreach ($doctorCountByCommune as $item) {
            $doctorCount[$item->commune] = $item->total;
        }

        // Compter les demandes par commune
        $naissanceCountByCommune = NaissanceCertificat::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $naissanceCount = [];
        foreach ($naissanceCountByCommune as $item) {
            $naissanceCount[$item->commune] = $item->total;
        }

        $naissanceDCountByCommune = NaissanceSimple::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $naissanceDCount = [];
        foreach ($naissanceDCountByCommune as $item) {
            $naissanceDCount[$item->commune] = $item->total;
        }

        $decesCountByCommune = DecesCertificat::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $decesCount = [];
        foreach ($decesCountByCommune as $item) {
            $decesCount[$item->commune] = $item->total;
        }

        $decesdejaCountByCommune = DecesSimple::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $decesdejaCount = [];
        foreach ($decesdejaCountByCommune as $item) {
            $decesdejaCount[$item->commune] = $item->total;
        }

        $mariageCountByCommune = Mariage::select('commune', DB::raw('count(*) as total'))
            ->groupBy('commune')
            ->get();
        $mariageCount = [];
        foreach ($mariageCountByCommune as $item) {
            $mariageCount[$item->commune] = $item->total;
        }

        // Récupérer la mairie sélectionnée et le montant saisi
        $mairieSelectionnee = $request->input('mairie_selectionnee');
        $ajoutSolde = $request->input('ajout_solde', 0); // Par défaut, 0 si non renseigné

        // Mettre à jour le solde de la mairie sélectionnée
        if ($mairieSelectionnee && $ajoutSolde) {
            $vendor = Mairie::find($mairieSelectionnee);
            if ($vendor) {
                $vendor->solde += $ajoutSolde; // Ajouter le montant saisi au solde actuel
                $vendor->save(); // Sauvegarder les modifications
            }
        }

        // Récupérer les soldes mis à jour
        $soldeRestantParCommune = [];
        foreach ($vendors as $vendor) {
            $soldeRestantParCommune[$vendor->name] = $vendor->solde;
        }

        return view('admin.mairie.index', compact('vendors', 'agentsCount', 'caisseCount', 'doctorCount','soldeRestantParCommune', 'ajoutSolde', 'mairieSelectionnee'));
    }

    // Les routes de creations de la mairie
    public function create(){
        $admin = Auth::guard('admin')->user();
        $vendor = Mairie::all();
        return view('admin.mairie.create', compact('vendor'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|unique:mairies,name',
            'email' => 'required|email|unique:mairies,email',
        ],[
            'name.required' => 'Le nom est obligatoire.',
            'name.unique' => 'Cette mairie est déjà inscrite.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail existe déjà.',
        ]);

        try {
            // Récupérer le vendor connecté
            $vendor = Auth::guard('admin')->user();

            if (!$vendor) {
                return redirect()->back()->withErrors(['error' => 'Impossible de récupérer les informations du mairie.']);
            }

            // Création du vendor
            $vendor = new Mairie();
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->password = Hash::make('password');
            $vendor->save();

            // Envoi de l'e-mail de vérification
            ResetCodePasswordMairie::where('email', $vendor->email)->delete();
            $code = rand(10000, 40000);

            ResetCodePasswordMairie::create([
                'code' => $code,
                'email' => $vendor->email,
            ]);

            Notification::route('mail', $vendor->email)
                ->notify(new SendEmailToMairieAfterRegistrationNotification($code, $vendor->email));

            return redirect()->route('admin.index')
                ->with('success', 'Mairie enregistré avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement du vendor: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    public function addSolde(Request $request)
    {
        // Valider les entrées
        $request->validate([
            'mairie_selectionnee' => 'required|exists:mairies,id',
            'ajout_solde' => 'required|numeric|min:0',
            'action' => 'required|in:ajouter,retirer', // Assurez-vous que l'action est soit 'ajouter' soit 'retirer'
        ]);

        // Récupérer la mairie sélectionnée, le montant saisi et l'action
        $mairieSelectionnee = $request->input('mairie_selectionnee');
        $ajoutSolde = $request->input('ajout_solde');
        $action = $request->input('action');

        // Mettre à jour le solde de la mairie sélectionnée
        $vendor = Mairie::find($mairieSelectionnee);
        if ($vendor) {
            if ($action === 'ajouter') {
                $vendor->solde += $ajoutSolde; // Ajouter le montant saisi au solde actuel
            } elseif ($action === 'retirer') {
                $vendor->solde -= $ajoutSolde; // Retirer le montant saisi du solde actuel
            }
            $vendor->save(); // Sauvegarder les modifications
        }

        // Rediriger vers la page précédente avec un message de succès
        return redirect()->route('admin.index')->with('success', 'Le montant a été ' . ($action === 'ajouter' ? 'ajouté' : 'retiré') . ' avec succès.');
}

}
