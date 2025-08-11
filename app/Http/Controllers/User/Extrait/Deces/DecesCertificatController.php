<?php

namespace App\Http\Controllers\User\Extrait\Deces;

use App\Http\Controllers\Controller;
use App\Http\Requests\saveDecesRequest;
use App\Models\DecesCertificat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DecesCertificatController extends Controller
{
    public function create()
    {
        return view('user.deces.certificat.create');
    }

    public function store(saveDecesRequest $request)
    {
        $imageBaseLink = '/images/deces/';

        // Liste des fichiers à traiter
        $filesToUpload = [
            'identiteDeclarant' => 'parent/',
            'acteMariage' => 'actemariage/',
            'deParLaLoi' => 'deparlaloi/', // Si ce fichier est soumis
        ];

        $uploadedPaths = []; // Contiendra les chemins des fichiers uploadés

        foreach ($filesToUpload as $fileKey => $subDir) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();
                $newFileName = (string) Str::uuid() . '.' . $extension;
                $file->storeAs("public/images/deces/$subDir", $newFileName);

                // Ajouter le chemin public à $uploadedPaths
                $uploadedPaths[$fileKey] = $imageBaseLink . "$subDir" . $newFileName;
            }
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Générer la référence ici dans le contrôleur
        $communeInitiale = strtoupper(substr($user->commune ?? 'X', 0, 1)); // 'X' si commune est null ou vide
        $anneeCourante = Carbon::now()->year;
        $reference = 'AD' . str_pad(DecesCertificat::getNextId(), 4, '0', STR_PAD_LEFT) . $communeInitiale . $anneeCourante; // AD pour Acte de Decès


        // Enregistrement de l'objet Deces
        $deces = new DecesCertificat();
        $deces->nomHopital = $request->nomHopital;
        $deces->dateDces = $request->dateDces;
        $deces->nomDefunt = $request->nomDefunt;
        $deces->dateNaiss = $request->dateNaiss;
        $deces->lieuNaiss = $request->lieuNaiss;
        $deces->identiteDeclarant = $uploadedPaths['identiteDeclarant'] ?? null;
        $deces->acteMariage = $uploadedPaths['acteMariage'] ?? null;
        $deces->deParLaLoi = $uploadedPaths['deParLaLoi'] ?? null; // Si présent
        $deces->choix_option = $request->choix_option;
        $deces->commune = $user->commune;
        $deces->etat = 'en attente';
        $deces->user_id = $user->id;  // Lier la demande à l'utilisateur connecté
        $deces->reference = $reference; // Assignez la référence générée

           // Ajout des informations de livraison si option livraison est choisie
        if ($request->input('choix_option') === 'livraison') {
            $deces->montant_timbre = $request->input('montant_timbre');
            $deces->montant_livraison = $request->input('montant_livraison');
            $deces->nom_destinataire = $request->input('nom_destinataire');
            $deces->prenom_destinataire = $request->input('prenom_destinataire');
            $deces->email_destinataire = $request->input('email_destinataire');
            $deces->contact_destinataire = $request->input('contact_destinataire');
            $deces->adresse_livraison = $request->input('adresse_livraison');
            $deces->code_postal = $request->input('code_postal');
            $deces->ville = $request->input('ville');
            $deces->commune_livraison = $request->input('commune_livraison');
            $deces->quartier = $request->input('quartier');
        }

        $deces->save();

        return redirect()->route('user.extrait.deces.index')->with('success', 'Votre demande a été traitée avec succès.');
    }

    public function delete(DecesCertificat $deces)
    {
        try {
            $deces->delete();
            return redirect()->route('user.extrait.deces.index')->with('success', 'La demande a été supprimée avec succès.');
            
        } catch (Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur lors de la suppression de la demande : ' . $e->getMessage());
            return redirect()->route('user.extrait.deces.index')->with('error', 'Une erreur est survenue lors de la suppression de la demande.');
        }
    }
}
