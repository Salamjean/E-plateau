<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Livreur;
use App\Models\NaissanceCertificat;
use App\Models\ResetCodePasswordAgent;
use App\Notifications\SendEmailToAgentAfterRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{

    public function create(){
        return view('mairie.agent.create');
    }

     public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'contact' => 'required|string|min:10',
            'commune' => 'required|string|max:255',
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
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
                return back()->withErrors(['error' => 'Impossible de récupérer les informations du mairie.'])->withInput();
            }

            // Traitement de l'image de profil
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            // Création de l'agent
            $agent = new Agent();
            $agent->name = $request->name;
            $agent->prenom = $request->prenom;
            $agent->email = $request->email;
            $agent->contact = $request->contact;
            $agent->password = Hash::make('default');
            $agent->profile_picture = $profilePicturePath;
            $agent->commune = $request->commune;
            $agent->communeM = $mairie->name;
            $agent->save();

            // Envoi de l'e-mail de vérification
            ResetCodePasswordAgent::where('email', $agent->email)->delete();
            $code = rand(100000, 400000);
            ResetCodePasswordAgent::create([
                'code' => $code,
                'email' => $agent->email,
            ]);

            Notification::route('mail', $agent->email)
                ->notify(new SendEmailToAgentAfterRegistrationNotification($code, $agent->email));

            return redirect()->route('agent.index')
                ->with('success', 'Agent d\'état civil enregistré avec succès.');

        } catch (\Exception $e) {
            Log::error('Error creating agent: ' . $e->getMessage()); // Enregistrement de l'erreur dans les logs
            return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])->withInput();
        }
    }

    public function index()
    {
        $mairie = Auth::guard('mairie')->user();
        $agents = Agent::whereNull('archived_at')
            ->where('communeM', $mairie->name)
            ->paginate(10);

        return view('mairie.agent.index', compact('agents'));
    }

     public function logout(){
        Auth::guard('agent')->logout();
        return redirect()->route('agent.login');
    }

    public function annuler(Request $request, $naissance) 
    {
        $admin = Auth::guard('agent')->user();

    
        $id = $naissance; 
        $motifAnnulation = $request->input('motif_annulation');
        $autreMotifText = $request->input('autre_motif_text'); 

        $demande = NaissanceCertificat::find($id);

        if($demande){
        
            $demande->motif_annulation = $motifAnnulation; 
            if ($motifAnnulation === 'autre') {
                $demande->autre_motif_text = $autreMotifText; 
            } else {
                $demande->autre_motif_text = null; 
            }
            $demande->etat = "réçu";
            $demande->save(); 

            $demande->archive();
            return redirect()->route('agent.demandes.naissance.index')->with('success', 'Demande de naissance annulée avec succès.');
            } else {
                return redirect()->route('agent.demandes.naissance.index')->with('error', 'La demande de naissance n\'existe pas.');
            }
        }

        public function delivery()
        {
            $agent = Auth::guard('agent')->user();
            $livreurs = Livreur::whereNull('archived_at')
                ->where('communeM', $agent->communeM)
                ->paginate(10);

            return view('agent.livreur.index', compact('livreurs'));
        }

        public function edit($id)
        {
            $agent = Agent::findOrFail($id);
            return view('mairie.agent.edit', compact('agent'));
        }

        public function update(Request $request, $id)
        {
            $agent = Agent::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:agents,email,' . $agent->id,
                'contact' => 'required|string|min:10',
                'commune' => 'required|string|max:255',
                'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);

            try {
                // Traitement de l'image
                if ($request->hasFile('profile_picture')) {
                    // Supprimer l'ancienne image si nécessaire
                    if ($agent->profile_picture) {
                        Storage::disk('public')->delete($agent->profile_picture);
                    }
                    $agent->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
                }

                // Mise à jour des infos
                $agent->name = $request->name;
                $agent->prenom = $request->prenom;
                $agent->email = $request->email;
                $agent->contact = $request->contact;
                $agent->commune = $request->commune;
                $agent->save();

                return redirect()->route('agent.index')
                    ->with('success', 'Agent mis à jour avec succès.');

            } catch (\Exception $e) {
                Log::error('Error updating agent: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])->withInput();
            }
        }

        public function destroy($id)
        {
            try {
                $agent = Agent::findOrFail($id);

                // Supprimer la photo si elle existe
                if ($agent->profile_picture) {
                    Storage::disk('public')->delete($agent->profile_picture);
                }

                $agent->delete();

                return redirect()->route('agent.index')
                    ->with('success', 'Agent supprimé avec succès.');
            } catch (\Exception $e) {
                Log::error('Error deleting agent: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression.']);
            }
        }



}
