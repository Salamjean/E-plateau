<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentDashboard extends Controller
{
    
    public function dashboard(Request $request) {
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();
        
        // Récupérer le mois et l'année sélectionnés
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonthHops = $request->input('month_hops', date('m'));
        $selectedYearHops = $request->input('year_hops', date('Y'));

        // Récupérer les données associées à la commune de cet admin pour le mois sélectionné
        // Données pour naissances, décès, et mariages
        $naissances = NaissanceCertificat::where('commune', $admin->communeM)
            ->where('is_read', false) // Filtrer pour les demandes non traitées
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'asc')
            ->get();

        $naissancesD = NaissanceSimple::where('commune', $admin->communeM)
            ->where('is_read', false) // Filtrer pour les demandes non traitées
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'asc')
            ->get();

        $deces = DecesCertificat::where('commune', $admin->communeM)
            ->where('is_read', false) // Filtrer pour les demandes non traitées
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'asc')
            ->get();

        $decesdeja = DecesSimple::where('commune', $admin->communeM)
            ->where('is_read', false) // Filtrer pour les demandes non traitées
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'asc')
            ->get();

        $mariages = Mariage::where('commune', $admin->communeM)
            ->where('is_read', false) // Filtrer pour les demandes non traitées
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'asc')
            ->get();

        // Données pour naisshops et deceshops
        $naisshops = DeclarationNaissance::where('commune', $admin->communeM)
            ->whereMonth('created_at', $selectedMonthHops)
            ->whereYear('created_at', $selectedYearHops)
            ->orderBy('created_at', 'asc')
            ->get();

        $deceshops = DeclarationDeces::where('commune', $admin->communeM)
            ->whereMonth('created_at', $selectedMonthHops)
            ->whereYear('created_at', $selectedYearHops)
            ->orderBy('created_at', 'asc')
            ->get();

        // Calcul des données globales
        $totalData = $naissances->count() + $naissancesD->count() + $deces->count()+ $decesdeja->count() + $mariages->count();
        $totalDataHops = $naisshops->count() + $deceshops->count();

        // Pourcentages
        $naissancePercentage = $totalData > 0 ? ($naissances->count() / $totalData) * 100 : 0;
        $naissanceDPercentage = $totalData > 0 ? ($naissancesD->count() / $totalData) * 100 : 0;
        $decesPercentage = $totalData > 0 ? ($deces->count() / $totalData) * 100 : 0;
        $decesdejaPercentage = $totalData > 0 ? ($decesdeja->count() / $totalData) * 100 : 0;
        $mariagePercentage = $totalData > 0 ? ($mariages->count() / $totalData) * 100 : 0;
        $naisshopPercentage = $totalDataHops > 0 ? ($naisshops->count() / $totalDataHops) * 100 : 0;
        $deceshopPercentage = $totalDataHops > 0 ? ($deceshops->count() / $totalDataHops) * 100 : 0;

        $Dece = $decesPercentage + $decesdejaPercentage;
        $NaissP = $naissancePercentage + $naissanceDPercentage;    
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
        $NaissHopTotal = $naisshopsdash + $deceshopsdash;

        // Récupération des données récentes (2 derniers éléments)
        $recentNaissances = $naissances->take(2);
        $recentNaissancesd = $naissancesD->take(2); // Filtrer pour les récentes non traitées
        $recentDeces = $deces->take(2);
        $recentDecesdeja = $decesdeja->take(2);
        $recentMariages = $mariages->take(2);
        $recentNaisshops = $naisshops->take(2);
        $recentDeceshops = $deceshops->take(2);

        // Retourne la vue avec les données
        return view('agent.dashboard', compact(
            'naissancedash', 'naisshopsdash', 'deceshopsdash','decesdejadash', 
            'NaissHopTotal', 'decesdash', 'NaissP', 'mariagedash', 
            'naissances', 'naissancesD', 'deces','decesdeja', 'mariages', 
            'totalDataHops', 'totalData', 'naissancePercentage', 
            'naissanceDPercentage', 'decesPercentage','decesdejaPercentage', 'mariagePercentage', 
            'naisshopPercentage', 'deceshopPercentage', 
            'recentNaissances', 'recentNaissancesd', 'recentDeces','recentDecesdeja', 
            'recentMariages', 'Naiss','Dece', 'NaissHop', 
            'selectedMonth', 'selectedYear', 
            'selectedMonthHops', 'selectedYearHops', 'recentNaisshops', 'recentDeceshops'
        ));

    }

    private function compterDemandesEnAttente($agentId)
    {
        return NaissanceCertificat::where('agent_id', $agentId)->where('etat', '!=', 'terminé')->count() +
                NaissanceSimple::where('agent_id', $agentId)->where('etat', '!=', 'terminé')->count() +
                DecesCertificat::where('agent_id', $agentId)->where('etat', '!=', 'terminé')->count() +
                DecesSimple::where('agent_id', $agentId)->where('etat', '!=', 'terminé')->count() +
                Mariage::where('agent_id', $agentId)->where('etat', '!=', 'terminé')->count();
    }

    private function traiterDemandeGenerique($modelClass, $id, $successRoute, $modelName)
    {
        $agent = Auth::guard('agent')->user();
        $pendingRequestsCount = $this->compterDemandesEnAttente($agent->id);

            if ($pendingRequestsCount >= 2) {
                return redirect()->route('agent.dashboard')->with('error', 'Vous avez 2 demandes en attente. Veuillez terminer les demandes en attente.');
            }

            $demande = $modelClass::find($id);

            if (!$demande) {
                return redirect()->route($successRoute)->with('error', 'Demande introuvable.'); 
            }

            if ($demande->agent_id) {
                return redirect()->route('agent.dashboard')->with('error', "Cette demande de {$modelName} a déjà été récupérée par un autre agent.");
            }

            $demande->is_read = true;
            $demande->agent_id = $agent->id;
            $demande->etat = 'en attente';
            $demande->save();

            return redirect()->route($successRoute)->with('success', "Demande de {$modelName} récupérée avec succès.");
        }

        public function traiterDemande($id)
        {
            $naissance = NaissanceCertificat::find($id);
            if ($naissance) {
                return $this->traiterDemandeGenerique(NaissanceCertificat::class, $id, 'agent.demandes.naissance.index', 'naissance');
            }

            $naissanceD = NaissanceSimple::find($id);
            if ($naissanceD) {
                return $this->traiterDemandeGenerique(NaissanceSimple::class, $id, 'agent.demandes.naissance.index', 'naissance'); 

            return redirect()->route('agent.demandes.naissance.index')->with('error', 'Demande introuvable.'); 
        }
    }

    public function traiterDemandeDeces($id)
    {
        $deces = DecesCertificat::find($id);
        if ($deces) {
            return $this->traiterDemandeGenerique(DecesCertificat::class, $id,'agent.demandes.deces.index' , 'décès');
        }

        $decesdeja = DecesSimple::find($id);
        if ($decesdeja) {
            return $this->traiterDemandeGenerique(DecesSimple::class, $id,'agent.demandes.deces.index' , 'décès');
        }

        return redirect()->route('agent.demandes.deces.index')->with('error', 'Demande introuvable.');
    }

    public function traiterDemandeMariage($id)
    {
        return $this->traiterDemandeGenerique(Mariage::class, $id,'agent.demandes.wedding.index' , 'mariage');
    }

}
