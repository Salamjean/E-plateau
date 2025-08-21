<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;

class DemandesDeclarationsController extends Controller
{
    public function declarationNaissance() {
        $naisshops = DeclarationNaissance::with('enfants')->get();
        return view('admin.declarations.naissance', compact('naisshops'));
    }

    public function declarationDeces(){
        $deceshops = DeclarationDeces::all();
       return view('admin.declarations.deces',compact('deceshops'));
   }

   public function naissance(){
        // Filtrer les naissances selon l'ID de l'utilisateur connecté
        $naissances = NaissanceCertificat::all();
        $naissancesD = NaissanceSimple::all();

        return view('admin.demandes.naissance', compact('naissances', 'naissancesD'));
    }

    public function deces(Request $request){
        // Initialiser la requête pour Deces en filtrant par commune
        $deces = DecesCertificat::all();
        $decesdeja = DecesSimple::all();
        return view('admin.demandes.deces', compact('deces', 'decesdeja'));
    }

    public function mariage(){
        $mariages = Mariage::all();
        return view('admin.demandes.mariage', compact('mariages'));
    }
}
