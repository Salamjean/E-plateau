<?php

namespace App\Http\Controllers\Doctor\Deces;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces as ModelsDeclarationDeces;
use App\Models\DeclarationNaissance;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class DeclarationDeces extends Controller
{
     public function index() {
        // Récupérer l'administrateur connecté
        $sousadmin = Auth::guard('doctor')->user();

        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->nomHop;
        $sousAdminId = $sousadmin->id; // Récupérer l'ID du sous-administrateur

        // Récupérer les déclarations de décès filtrées par la commune de l'administrateur et l'ID du sous-administrateur
        $deceshops = ModelsDeclarationDeces::where('nomHop', $communeAdmin)
            ->where('doctor_id', $sousAdminId) // Filtrer par ID de sous-administrateur
            ->get();

        return view('doctor.deces.index', ['deceshops' => $deceshops]);
    }

    public function create(){
        return view('doctor.deces.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'NomM' => 'required',
            'PrM' => 'required',
            'DateNaissance' => 'required|date',
            'DateDeces' => 'required|date',
            'nomHop' => 'required',
            'commune' => 'required',
            'choix' => 'required',
            'Remarques' => 'nullable|string',
        ]);
        $sousadmin = Auth::guard('doctor')->user();
        // Création dans la base de données
        $decesHop = ModelsDeclarationDeces::create([
            'NomM' => $validatedData['NomM'],
            'PrM' => $validatedData['PrM'],
            'DateNaissance' => $validatedData['DateNaissance'],
            'DateDeces' => $validatedData['DateDeces'],
            'nomHop' => $validatedData['nomHop'],
            'commune' => $validatedData['commune'],
            'choix' => $validatedData['choix'],
            'Remarques' => $validatedData['Remarques'] ?? null,
            'doctor_id' => $sousadmin->id,
        ]);

        // Génération des codes
        $anneeDeces = date('Y', strtotime($decesHop->DateDeces));
        $id = $decesHop->id;
        $codeDM = "DM{$anneeDeces}{$id}225";
        $codeCMD = "CMD{$anneeDeces}{$id}225";

        $decesHop->update([
            'codeDM' => $codeDM,
            'codeCMD' => $codeCMD,
        ]);

        // Génération du QR code
        $qrCodeData = 
        "N° CMD: {$codeCMD}\n" .
        "Les details de décès:\n" .
        "Nom du défunt: {$validatedData['NomM']}\n" .
        "Prénom du défunt: {$validatedData['PrM']}\n" .
        "Date de naissance  du défunt: {$validatedData['DateNaissance']}\n" .
        "Date de décès: {$validatedData['DateDeces']}\n" .
        "Hôpital: {$validatedData['nomHop']}\n" .
        "Commune: {$validatedData['commune']}\n" .
        "Cause de décès: {$validatedData['Remarques']}";

        $qrCode = QrCode::create($qrCodeData)
            ->setSize(300)
            ->setMargin(10);

        // Écrire le QR code dans un fichier
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Générer un nom de fichier unique (optionnel)
        $qrCodeFileName = "qrcode_{$decesHop->id}.png"; // Nom du fichier basé sur l'ID
        $qrCodePath = "deces_hops/{$qrCodeFileName}"; // Chemin relatif dans le dossier 'deces_hops'

        // Utiliser le système de stockage de Laravel pour enregistrer le fichier
        Storage::disk('public')->put($qrCodePath, $result->getString());

        // Récupérer les informations du sous-admin
        $sousadmin = Auth::guard('doctor')->user();

        // Générer le PDF
        $pdf = PDF::loadView('doctor.deces.pdf', compact('decesHop', 'codeDM', 'codeCMD', 'sousadmin', 'qrCodePath'));
        $pdfFileName = "declaration_deces_{$decesHop->id}.pdf";
        $pdf->save(storage_path("app/public/deces_hops/{$pdfFileName}"));


        // Générer la contagion PDF
        $pdf3 = PDF::loadView('doctor.deces.contagionpdf', compact('decesHop', 'codeDM', 'codeCMD', 'sousadmin', 'qrCodePath'))
        ->setPaper('a4', 'landscape');
        $pdfFileName3 = "contagion_{$decesHop->id}.pdf";
        $pdf3->save(storage_path("app/public/deces_hops/{$pdfFileName3}"));

        // Retourner le PDF pour téléchargement direct
        return redirect()->route('statement.index.death')->with('success', 'Déclaration de décès effectuée avec succès');
    }

    public function download($id)
    {
        // Récupérer l'objet NaissHop
        $decesHop = ModelsDeclarationDeces::findOrFail($id);

        // Récupérer les informations du sous-admin connecté
        $sousadmin = Auth::guard('doctor')->user(); // Supposons que le sous-admin est connecté via `auth`

        if (!$sousadmin) {
            return back()->withErrors(['error' => 'doctor non authentifié.']);
        }

        // Générer le PDF avec les données
        $pdf = PDF::loadView('doctor.deces.pdf', compact('decesHop', 'sousadmin'));

        // Retourner le PDF pour téléchargement direct
        return $pdf->download("declaration_décès_{$decesHop->id}.pdf");
    }

    public function downloadcontagion($id)
    {
        // Définir la locale en français pour Carbon
        App::setLocale('fr');

        // Récupérer l'objet DecesHop
        $decesHop = ModelsDeclarationDeces::findOrFail($id);

        // Récupérer les informations du sous-admin connecté
        $sousadmin = Auth::guard('doctor')->user();

        if (!$sousadmin) {
            return back()->withErrors(['error' => 'doctor non authentifié.']);
        }

        // Générer le PDF avec les données
        $pdf = PDF::loadView('doctor.deces.contagionpdf', compact('decesHop', 'sousadmin'));

        // Retourner le PDF pour téléchargement direct
        return $pdf->download("contagion_{$decesHop->id}.pdf");
    }
    public function edit(ModelsDeclarationDeces $deceshop){
        return view('doctor.deces.edit', compact('deceshop'));
    }

    public function update(Request $request,ModelsDeclarationDeces $deceshop){
        try {
            $deceshop->NomM = $request->NomM;
            $deceshop->PrM = $request->PrM;
            $deceshop->DateNaissance = $request->DateNaissance;
            $deceshop->DateDeces = $request->DateDeces;
            $deceshop->choix = $request->choix;
            $deceshop->Remarques = $request->Remarques;
            $deceshop->nomHop = $request->nomHop;
            $deceshop->commune = $request->commune;
            $deceshop->update();

            return redirect()->route('statement.index.death')->with('success','Déclaration de décès mise à jour.');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function show($id)
    {
        $deceshop = ModelsDeclarationDeces::findOrFail($id);
        return view('doctor.deces.details', compact('deceshop'));
    }

    public function delete(ModelsDeclarationDeces $deceshop){
        try {
            $deceshop->delete();
            return redirect()->route('statement.index.death')->with('success1','La declaration a été supprimé avec succès.');
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('error','Une erreur est survenue lors de la suppression de la declaration');
        }
    }
}
