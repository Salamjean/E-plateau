<?php

namespace App\Http\Controllers\User\Extrait\Naissance;

use App\Http\Controllers\Controller;
use App\Http\Requests\saveNaissanceRequest;
use App\Models\DeclarationNaissance;
use App\Models\NaissanceCertificat;
use App\Services\InfobipService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificatNaissance extends Controller
{
    public function create(){
        $naisshop = DeclarationNaissance::all();
        return view('user.naissance.certificat.create', compact('naisshop'));
    }

    public function store(saveNaissanceRequest $request, InfobipService $infobipService)
    {
        Log::info('Store method called', $request->all());
        $imageBaseLink = '/images/naissances/';

        // Liste des fichiers à traiter
        $filesToUpload = [
            'identiteDeclarant' => 'parent/',
            'cdnaiss' => 'cdn/',
            'acteMariage' => 'actemariage/',
        ];

        $uploadedPaths = []; // Contiendra les chemins des fichiers uploadés

        foreach ($filesToUpload as $fileKey => $subDir) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();
                $newFileName = (string) Str::uuid() . '.' . $extension;
                $file->storeAs("public/images/naissances/$subDir", $newFileName);

                // Ajouter le chemin public à $uploadedPaths
                $uploadedPaths[$fileKey] = $imageBaseLink . "$subDir" . $newFileName;
            }
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Générer la référence ici dans le contrôleur
        $communeInitiale = strtoupper(substr($user->commune ?? 'X', 0, 1)); // 'X' si commune est null ou vide
        $anneeCourante = Carbon::now()->year;
        $reference = 'AN' . str_pad(NaissanceCertificat::getNextId(), 4, '0', STR_PAD_LEFT) . $communeInitiale . $anneeCourante;


        // Enregistrement de l'objet Naissance
        $naissance = new NaissanceCertificat();
        $naissance->nomHopital = $request->nomHopital;
        $naissance->nomDefunt = $request->nomDefunt;
        $naissance->dateNaiss = $request->dateNaiss;
        $naissance->lieuNaiss = $request->lieuNaiss;
        $naissance->identiteDeclarant = $uploadedPaths['identiteDeclarant'] ?? null;
        $naissance->cdnaiss = $uploadedPaths['cdnaiss'] ?? null;
        $naissance->acteMariage = $uploadedPaths['acteMariage'] ?? null;
        $naissance->commune = $user->commune;
        $naissance->reference = $reference; // Assignez la référence générée
        $naissance->nom = $request->nom;
        $naissance->prenom = $request->prenom;
        $naissance->choix_option = $request->choix_option;
        $naissance->nompere = $request->nompere;
        $naissance->prenompere = $request->prenompere;
        $naissance->datepere = $request->datepere;
        $naissance->etat = 'en attente';
        $naissance->user_id = $user->id;  // Lier la demande à l'utilisateur connecté

        // Ajout des informations de livraison si option livraison est choisie
        if ($request->input('choix_option') === 'livraison') {
            $naissance->montant_timbre = $request->input('montant_timbre');
            $naissance->montant_livraison = $request->input('montant_livraison');
            $naissance->nom_destinataire = $request->input('nom_destinataire');
            $naissance->prenom_destinataire = $request->input('prenom_destinataire');
            $naissance->email_destinataire = $request->input('email_destinataire');
            $naissance->contact_destinataire = $request->input('contact_destinataire');
            $naissance->adresse_livraison = $request->input('adresse_livraison');
            $naissance->code_postal = $request->input('code_postal');
            $naissance->ville = $request->input('ville');
            $naissance->commune_livraison = $request->input('commune_livraison');
            $naissance->quartier = $request->input('quartier');
        }

        $naissance->save();
         $phoneNumber = $user->indicatif . $user->contact;
        $message = "Bonjour {$user->name}, votre demande d'extrait de naissance a bien été transmise à la mairie de {$user->commune}. Référence: {$naissance->reference}.
Vous pouvez suivre l'état de votre demande en cliquant sur ce lien : https://edemarchee-ci.com/E-ci-recherche/demande";
        $infobipService->sendSms($phoneNumber, $message);

        return redirect()->route('user.extrait.simple.index')->with('success', 'Votre demande a été traitée avec succès.');
    }

    public function delete(NaissanceCertificat $naissance)
    {
        try {
            $naissance->delete();
            return redirect()->route('user.extrait.simple.index')->with('success', 'La demande a été supprimée avec succès.');
        } catch (Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur lors de la suppression de la demande : ' . $e->getMessage());
            // Rediriger avec un message d'erreur
            return redirect()->route('user.extrait.simple.index')->with('error1', 'Une erreur est survenue lors de la suppression de la demande.');
        }
    }

    public function updateprenom(Request $request, $id)
    {
        Log::info('Méthode updateprenom appelée avec ID:', ['id' => $id]);
        
        // Validation des données
        $request->validate([
            'newPrenom' => 'required|string|max:255',
            'identiteDeclarant' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cdnaiss' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $naissance = NaissanceCertificat::find($id);

        if (!$naissance) {
            return response()->json(['success' => false, 'message' => 'Enregistrement non trouvé']);
        }

        // Mettre à jour le prénom
        $naissance->prenom = $request->newPrenom;
        
        // Gérer le fichier identiteDeclarant
        if ($request->hasFile('identiteDeclarant')) {
            // Supprimer l'ancien fichier s'il existe
            if ($naissance->identiteDeclarant && Storage::exists($naissance->identiteDeclarant)) {
                Storage::delete($naissance->identiteDeclarant);
            }
            
            // Stocker le nouveau fichier
            $path = $request->file('identiteDeclarant')->store('documents', 'public');
            $naissance->identiteDeclarant = $path;
        }
        
        // Gérer le fichier cdnaiss
        if ($request->hasFile('cdnaiss')) {
            // Supprimer l'ancien fichier s'il existe
            if ($naissance->cdnaiss && Storage::exists($naissance->cdnaiss)) {
                Storage::delete($naissance->cdnaiss);
            }
            
            // Stocker le nouveau fichier
            $path = $request->file('cdnaiss')->store('documents', 'public');
            $naissance->cdnaiss = $path;
        }
        
        // Réinitialiser les champs d'archivage
        $naissance->archived_at = null;
        $naissance->motif_annulation = null;
        $naissance->autre_motif_text = null;
        $naissance->etat = 'en attente';
        
        $naissance->save();

        return response()->json([
            'success' => true, 
            'message' => 'Modifications enregistrées avec succès'
        ]);
    }
}
