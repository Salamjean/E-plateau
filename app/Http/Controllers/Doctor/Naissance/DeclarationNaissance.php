<?php

namespace App\Http\Controllers\Doctor\Naissance;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance as ModelsDeclarationNaissance;
use App\Models\Enfant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Exception;
use PDF;

class DeclarationNaissance extends Controller
{
    public function index() {
        // Récupérer l'administrateur connecté
        $sousadmin = Auth::guard('doctor')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->nomHop;
        $sousAdminId = $sousadmin->id; // Récupérer l'ID du sous-administrateur
    
        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur et l'ID du sous-administrateur
        $naisshops = ModelsDeclarationNaissance::where('NomEnf', $communeAdmin)
            ->where('doctor_id', $sousAdminId) // Filtrer par ID de sous-administrateur
            ->with('enfants') // Chargement eager des relations 'enfants' pour éviter le problème N+1
            ->get();
            
    
        return view('doctor.naissance.index', ['naisshops' => $naisshops]);
    }

    public function create(){
        return view('doctor.naissance.create');
    }

    public function store(Request $request)
    {
        // *** Construction des règles de validation (statiques et dynamiques) ***
        $rules = [
            'NomM' => 'required',
            'PrM' => 'required',
            'contM' => 'required|unique:declaration_naissances,contM|max:11',
            'dateM' => 'required',
            'CNI_mere' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'NomP' => 'required',
            'PrP' => 'required',
            'contP' => 'required|unique:declaration_naissances,contP|max:11',
            'nombreEnf' => 'required|integer|min:1', // Validation pour le nombre d'enfants
            'NomEnf' => 'required', // Nom de l'hôpital, toujours nécessaire
            'commune' => 'required', // Commune, toujours nécessaire
            'codeCMU' => 'required',
            'lien' => 'required',
            'CNI_Pere' => 'nullable',
        ];

        // Règles de validation dynamiques pour les informations des enfants
        $nombreEnfants = $request->input('nombreEnf'); // Récupérer nombre_enfants de la requête
        if ($nombreEnfants) { // Vérifier si nombre_enfants est défini
            for ($i = 1; $i <= $nombreEnfants; $i++) {
                $rules['DateNaissance_enfant_' . $i] = 'required|date';
                $rules['sexe_enfant_' . $i] = 'required|in:masculin,feminin';
            }
        }

        // Messages d'erreur personnalisés (facultatif, mais bonne pratique)
        $messages = [
            'NomM.required' => 'Le champ nom de la mère est obligatoire.',
            'PrM.required' => 'Le champ prénom de la mère est obligatoire.',
            'contM.required' => 'Le champ numéro de téléphone de la mère est obligatoire.',
            'contM.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'contP.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'CNI_mere.mimes' => 'Le fichier doit être au format jpeg, png, jpg ou pdf.',
            'CNI_mere.max' => 'Le fichier ne doit pas dépasser 2Mo.',
            'CNI_mere.required' => 'Le champ CNI de la mère est obligatoire.',
            'NomP.required' => 'Le champ nom du père est obligatoire.',
            'PrP.required' => 'Le champ prénom du père est obligatoire.',
            'contP.required' => 'Le champ numéro de téléphone du père est obligatoire.',
            'NomEnf.required' => 'Le champ nom de l\'enfant est obligatoire.',
            'commune.required' => 'Le champ commune est obligatoire.',
            'codeCMU.required' => 'Le champ code CMU est obligatoire.',
            'lien.required' => 'Le champ lien est obligatoire.',
            'CNI_Pere.required' => 'Le champ CNI du père est obligatoire.',
            'nombreEnf.required' => 'Le champ Nombre d\'enfants est obligatoire.',
            'nombreEnf.integer' => 'Le champ Nombre d\'enfants doit être un nombre entier.',
            'nombreEnf.min' => 'Le champ Nombre d\'enfants doit être au minimum 1.',
        ];

        // Ajouter des messages d'erreur dynamiques pour les enfants
        if ($nombreEnfants) {
            for ($i = 1; $i <= $nombreEnfants; $i++) {
                $messages['DateNaissance_enfant_' . $i . '.required'] = 'Le champ Date de naissance de l\'enfant ' . $i . ' est obligatoire.';
                $messages['DateNaissance_enfant_' . $i . '.date'] = 'Le champ Date de naissance de l\'enfant ' . $i . ' doit être une date valide.';
                $messages['sexe_enfant_' . $i . '.required'] = 'Le champ Sexe de l\'enfant ' . $i . ' est obligatoire.';
                $messages['sexe_enfant_' . $i . '.in'] = 'Le champ Sexe de l\'enfant ' . $i . ' doit être masculin ou feminin.';
            }
        }


        // *** Validation de toutes les données en utilisant les règles définies ***
        $validatedData = $request->validate($rules, $messages);

        // Gérer les fichiers
        $imageBaseLink = '/images/naissances/'; // Base pour les images
        $uploadedPaths = []; // Pour stocker les chemins des fichiers

        // Traitement du fichier CNI de la mère
        if ($request->hasFile('CNI_mere')) {
            $file = $request->file('CNI_mere');
            $extension = $file->getClientOriginalExtension();
            $newFileName = (string) Str::uuid() . '.' . $extension;
            $file->storeAs('public/images/naissances/cni/', $newFileName);
            $uploadedPaths['CNI_mere'] = $imageBaseLink . "cni/" . $newFileName;
        }

        $doctor = Auth::guard('doctor')->user();
        // Création dans la base de données NaissHop
        $declaration = ModelsDeclarationNaissance::create([
            'NomM' => $validatedData['NomM'],
            'PrM' => $validatedData['PrM'],
            'contM' => $validatedData['contM'],
            'dateM' => $validatedData['dateM'],
            'CNI_mere' => $uploadedPaths['CNI_mere'] ?? null,
            'NomP' => $validatedData['NomP'],
            'PrP' => $validatedData['PrP'],
            'contP' => $validatedData['contP'],
            'NomEnf' => $validatedData['NomEnf'], // Nom de l'hôpital
            'commune' => $validatedData['commune'],
            'codeCMU' => $validatedData['codeCMU'],
            'lien' => $validatedData['lien'],
            'CNI_Pere' => $validatedData['CNI_Pere'],
            'doctor_id' => $doctor->id,
        ]);

        // Génération des codes
        $anneeNaissance = date('Y', strtotime($validatedData['DateNaissance_enfant_1'])); // Utiliser la date du premier enfant pour l'année
        $id = $declaration->id;
        $codeDM = "DM{$anneeNaissance}{$id}225";
        $codeCMN = "CMN{$anneeNaissance}{$id}225";

        $declaration->update([
            'codeDM' => $codeDM,
            'codeCMN' => $codeCMN,
        ]);

        // Création des enregistrements Enfant
        for ($i = 1; $i <= $nombreEnfants; $i++) {
            Enfant::create([
                'declaration_naissance_id' => $declaration->id,
                'nombreEnf' => $validatedData['nombreEnf'], // Enregistrer le nombre d'enfants dans naiss_hops
                'date_naissance' => $validatedData['DateNaissance_enfant_' . $i],
                'sexe' => $validatedData['sexe_enfant_' . $i],
            ]);
        }


        $doctor = Auth::guard('doctor')->user();
        // Vérifiez si l'utilisateur est authentifié
        if ($doctor) {
            $nomdoctor = $doctor->name . ' ' . $doctor->prenom; // Assurez-vous que 'name' est le bon attribut
        } else {
            $nomdoctor = 'Inconnu'; // Valeur par défaut si l'utilisateur n'est pas authentifié
        }
        $dateCreation = $declaration->created_at->format('d/m/Y H:i:s');
        // Génération du QR code (adapter les informations selon le besoin, ici on prend les infos du premier enfant)
        $qrCodeData =
            "N° CMN: {$codeCMN}\n" .
            "Les Informations concernants la mère \n" .
            "Nom et prénom de la mère: {$validatedData['NomM']} {$validatedData['PrM']}\n" .
            "Contact de la mère: {$validatedData['contM']}\n" .
            "Les Informations concernants l'enfant (Premier enfant) \n" . // Adapter si besoin pour plusieurs enfants
            "Date de naissance : {$validatedData['DateNaissance_enfant_1']}\n" .
            "Sexe : {$validatedData['sexe_enfant_1']}\n" .
            "Hôpital de naissance : {$validatedData['NomEnf']}\n" .
            "Certificat délivré par le Dr. : {$nomdoctor}\n" .
            "Date et Heure de déclaration : {$dateCreation}";


        $qrCode = QrCode::create($qrCodeData)
            ->setSize(300)
            ->setMargin(10);

        // Générer le QR code
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Sauvegarder l'image du QR code
        $qrCodeFileName = "qrcode_{$declaration->id}.png"; // Nom du fichier
        $qrCodePath = "declarations/naissances/{$qrCodeFileName}"; // Chemin relatif dans le dossier 'naiss_hops'

        // Utiliser le système de stockage de Laravel pour enregistrer le fichier
        Storage::disk('public')->put($qrCodePath, $result->getString());

        // Récupérer les informations du sous-admin
        $doctor = Auth::guard('doctor')->user();
        // Générer le PDF
        $pdf = PDF::loadView('doctor.naissance.pdf', compact('declaration', 'codeDM', 'codeCMN', 'doctor', 'qrCodePath','nombreEnfants')); // Adapter la vue PDF pour gérer les enfants

        // Sauvegarder le PDF dans le dossier public
        $pdfFileName = "declaration_{$declaration->id}.pdf";
        $pdf->save(storage_path("app/public/declarations/naissances{$pdfFileName}"));

        // Retourner le PDF pour téléchargement direct
        return redirect()->route('statement.index')->with('success', 'Déclaration effectuée avec succès');
    }

    public function download($id)
    {
        // Récupérer l'objet NaissHop
        $declaration = ModelsDeclarationNaissance::with('enfants')->findOrFail($id);

        // Récupérer les informations du sous-admin connecté
        $doctor = Auth::guard('doctor')->user(); // Supposons que le sous-admin est connecté via `auth`

        if (!$doctor) {
            return back()->withErrors(['error' => 'Doctor non authentifié.']);
        }

        // Générer le PDF avec les données
        $pdf = PDF::loadView('doctor.naissance.pdf', compact('declaration', 'doctor'));

        // Retourner le PDF pour téléchargement direct
        return $pdf->download("declaration_{$declaration->id}.pdf");
    }

    public function edit(ModelsDeclarationNaissance $naisshop){
        return view('doctor.naissance.edit', compact('naisshop'));
    }

    public function update(Request $request, ModelsDeclarationNaissance $naisshop)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'NomM' => 'required',
                'PrM' => 'required',
                'contM' => 'required',
                'dateM' => 'required|date',
                'NomP' => 'required',
                'PrP' => 'required',
                'contP' => 'required',
                'CNI_Pere' => 'required',
                'lien' => 'required',
                'codeCMU' => 'required',
                'nombreEnf' => 'required|integer|min:1',
                'NomEnf' => 'required',
                'commune' => 'required',
            ]);
    
            // Gestion du fichier CNI de la mère
            if ($request->hasFile('CNI_mere')) {
                // Supprimer l'ancien fichier s'il existe
                if ($naisshop->CNI_mere && Storage::exists($naisshop->CNI_mere)) {
                    Storage::delete($naisshop->CNI_mere);
                }
    
                $path = $request->file('CNI_mere')->store('public/images/naissances/cni');
                $validatedData['CNI_mere'] = str_replace('public/', '', $path);
            }
    
            // Mise à jour des informations principales
            $naisshop->update($validatedData);
    
            // Gestion des enfants
            $naisshop->enfants()->delete(); // Supprime les anciens enfants
    
            // Crée les nouveaux enfants
            for ($i = 1; $i <= $request->nombreEnf; $i++) {
                Enfant::create([
                    'declaration_naissance_id' => $naisshop->id,
                    'date_naissance' => $request->input('DateNaissance_enfant_'.$i),
                    'sexe' => $request->input('sexe_enfant_'.$i),
                    'nombreEnf' => $request->nombreEnf
                ]);
            }
    
            return redirect()->route('statement.index')
                ->with('success', 'Déclaration de naissance mise à jour avec succès');
    
        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $naisshop = ModelsDeclarationNaissance::findOrFail($id); // Récupérer les données ou générer une erreur 404 si non trouvé
        return view('doctor.naissance.details', compact('naisshop'));
    }

    public function delete(ModelsDeclarationNaissance $naisshop){
        try {
            $naisshop->delete();
            return redirect()->route('statement.index')->with('success1','La declaration a été supprimé avec succès.');
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('error','Une erreur est survenue lors de la suppression du Docteur');
        }
    }
}
