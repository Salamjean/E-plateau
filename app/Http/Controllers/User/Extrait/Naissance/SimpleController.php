<?php

namespace App\Http\Controllers\User\Extrait\Naissance;

use App\Http\Controllers\Controller;
use App\Http\Requests\saveNaissanceDRequest;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use App\Services\InfobipService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SimpleController extends Controller
{
    public function index(){

        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Filtrer les naissances selon l'ID de l'utilisateur connecté
        $naissances = NaissanceCertificat::where('user_id', $user->id)->where('etat','!=','terminé')->paginate(20);
        $naissancesD = NaissanceSimple::where('user_id', $user->id)->where('etat','!=','terminé')->paginate(20);

        // Retourner la vue avec les données
        return view('user.naissance.index', compact( 'naissancesD', 'naissances'));
        
    }

    public function create()
    {
        $userConnecté = Auth::user();
        return view('user.naissance.simple.create', [
            'userName' => $userConnecté ? $userConnecté->name : '', 
            'userPrenom' => $userConnecté ? $userConnecté->prenom : '', 
            'userCommune' => $userConnecté ? $userConnecté->commune : '', 
            'userCMU' => $userConnecté ? $userConnecté->CMU : '', 
        ]);
    }

    public function store(Request $request, InfobipService $infobipService)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'prenom' => 'required',
            'number' => 'required',
            'DateR' => 'required',
            'CMU' => 'nullable',
            'commune' => 'required',
            'CNI' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
        ],[
             'type.required' => 'le type d\'extrait que vous-voulez demander est obligatoire',
            'name.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'number.required' => 'Le numéro de registre sur l\'extrait est obligatoire',
            'DateR.required' => 'La date de registre est obligatoire',
            'CMU.required' => 'Le numéro de CMU est obligatoire',
            'commune.required' => 'La commune est obligatoire',
            'CNI.required' => 'Le champ CNI est obligatoire',
            'CNI.mimes' => 'Le format du fichier doit être PNG, JPG, JPEG ou PDF',
            'CNI.max' => 'Le fichier ne doit pas dépasser 1Mo',
        ]);
        // Log des données de la requête
        Log::info('Store method called', $request->all());

        // Configuration des chemins pour le stockage des fichiers
        $imageBaseLink = '/images/naissanceds/';
        $filesToUpload = [
            'CNI' => 'cni/',
        ];
        $uploadedPaths = [];

        // Traitement des fichiers uploadés
        foreach ($filesToUpload as $fileKey => $subDir) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();
                $newFileName = (string) Str::uuid() . '.' . $extension;
                $file->storeAs("public/images/naissanceds/$subDir", $newFileName);
                $uploadedPaths[$fileKey] = $imageBaseLink . "$subDir" . $newFileName;
            }
        }

        // Récupération de l'utilisateur connecté
        $user = Auth::user();

        // Génération de la référence
        $communeInitiale = strtoupper(substr($user->commune ?? 'X', 0, 1)); // 'X' si commune est null ou vide
        $anneeCourante = Carbon::now()->year;
        $reference = 'ANJ' . str_pad(NaissanceSimple::getNextId(), 4, '0', STR_PAD_LEFT) . $communeInitiale . $anneeCourante;

        // Création de la demande d'extrait de naissance
        $naissanced = new NaissanceSimple();
        $naissanced->pour = $request->pour;
        $naissanced->type = $request->type;
        $naissanced->name = $request->name;
        $naissanced->prenom = $request->prenom;
        $naissanced->number = $request->number;
        $naissanced->DateR = $request->DateR;
        $naissanced->commune = $request->commune;
        $naissanced->CNI = $uploadedPaths['CNI'] ?? null;
        $naissanced->CMU = $request->CMU;
        $naissanced->choix_option = $request->choix_option;
        $naissanced->user_id = $user->id;
        $naissanced->etat = 'en attente';
        $naissanced->reference = $reference;
       

        // Ajout des informations de livraison si l'option "livraison" est choisie
        if ($request->input('choix_option') === 'livraison') {
            $naissanced->montant_timbre = $request->input('montant_timbre');
            $naissanced->montant_livraison = $request->input('montant_livraison');
            $naissanced->nom_destinataire = $request->input('nom_destinataire');
            $naissanced->prenom_destinataire = $request->input('prenom_destinataire');
            $naissanced->email_destinataire = $request->input('email_destinataire');
            $naissanced->contact_destinataire = $request->input('contact_destinataire');
            $naissanced->adresse_livraison = $request->input('adresse_livraison');
            $naissanced->code_postal = $request->input('code_postal');
            $naissanced->ville = $request->input('ville');
            $naissanced->commune_livraison = $request->input('commune_livraison');
            $naissanced->quartier = $request->input('quartier');
        }

         $naissanced->save();
//          $phoneNumber = $user->indicatif . $user->contact;
//     Log::info('Numéro de téléphone construit : ' . $phoneNumber);

//     // Envoi du SMS
//     $message = "Bonjour {$user->name}, votre demande d'extrait de naissance a bien été transmise à la mairie de {$user->commune}. Référence : {$naissanced->reference}.
// Vous pouvez suivre l'état de votre demande en cliquant sur ce lien : https://edemarchee-ci.com/E-ci-recherche/demande";
//     $smsResult = $infobipService->sendSms($phoneNumber, $message);
        // Redirection avec un message de succès
        return redirect()->route('user.extrait.simple.index')->with('success', 'Votre demande a été traitée avec succès.');
    }

    public function delete(NaissanceSimple $naissanceD)
    {
        try {
            $naissanceD->delete();
            return redirect()->route('user.extrait.simple.index')->with('success', 'La demande a été supprimée avec succès.');
        } catch (Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur lors de la suppression de la demande : ' . $e->getMessage());
            // Rediriger avec un message d'erreur
            return redirect()->route('user.extrait.simple.index')->with('error1', 'Une erreur est survenue lors de la suppression de la demande.');
        }
    }
}
