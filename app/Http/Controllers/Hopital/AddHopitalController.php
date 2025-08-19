<?php

namespace App\Http\Controllers\Hopital;

use App\Http\Controllers\Controller;
use App\Models\Sanitaire;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddHopitalController extends Controller
{
    public function index(){
        $sanitaires = Sanitaire::get();
        return view('hopital.sanitary.index', compact('sanitaires'));
    }

    public function create(){
        return view('hopital.sanitary.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name_hospial' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ],[
            'name_hospial.required' => 'Le nom est requis.',
            'name_hospial.string' => 'Le nom doit être une chaîne de caractères.',
            'name_hospial.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'type.required' => 'Le prénom est requis.',
            'type.string' => 'Le prénom doit être une chaîne de caractères.',
            'type.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
        ]);
        try {
            // Récupérer le docteur connecté
            $hopital = auth('hopital')->user();	
        
            if (!$hopital || !$hopital->nomHop || !$hopital->commune) {
                return redirect()->back()->withErrors(['error' => 'Impossible de récupérer le nom de l\'hôpital.']);
            }
        
            // Création du sous-admin
            $sanitaire = new Sanitaire();
            $sanitaire->name_hospial = $request->name_hospial;
            $sanitaire->type = $request->type;
            $sanitaire->commune = $hopital->commune; 
            $sanitaire->save();

            return redirect()->route('sanitary.index')->with('success', 'Centre de santé enregistré a été ajouté avec succès.');

        } catch (Exception $e) {
            Log::error('Erreur création Centre de santé: ' . $e->getMessage());
            throw new Exception('Une erreur est survenue lors de la création Centre de santé.');
        }
    }
}
