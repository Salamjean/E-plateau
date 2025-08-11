<?php

namespace App\Http\Controllers;

use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationCM extends Controller
{
    public function verifierCMN(Request $request)
    {
        try {
            $request->validate(['codeCMN' => 'required|string']);
            
            $naissHop = DeclarationNaissance::where('codeCMN', $request->codeCMN)
                            ->first();

            if (!$naissHop) {
                return response()->json([
                    'existe' => false,
                    'message' => 'Code CMN introuvable'
                ], 404);
            }

            return response()->json([
                'existe' => true,
                'nomHopital' => $naissHop->NomEnf ?? 'Non spécifié', // Colonne NomEnf pour l'hôpital
                'nomMere' => ($naissHop->NomM ?? '') . ' ' . ($naissHop->PrM ?? ''), // Colonnes NomM et PrM
                'nomPere' => ($naissHop->NomP ?? '') . ' ' . ($naissHop->PrP ?? ''), // Colonnes NomP et PrP
                'dateNaiss' => $naissHop->DateN ? [$naissHop->DateN] : [] // Colonne DateN pour la date de naissance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifierCMD(Request $request)
    {
        $validatedData = $request->validate([
            'codeCMN' => 'required|string|max:50', // Validation de l'entrée
        ]);

        $codeCMN = $validatedData['codeCMN'];

        // Recherche du dossier médical
        $decesHop = DeclarationDeces::where('codeCMD', $codeCMN)->first();

        if ($decesHop) {
            return response()->json([
                'existe' => true,
                'nomHopital' => $decesHop->nomHop,
                'nomDefunt' => $decesHop->NomM . ' ' . $decesHop->PrM,
                'dateNaiss' => $decesHop->DateNaissance,
                'dateDeces' => $decesHop->DateDeces,
                'lieuNaiss' => $decesHop->commune,
            ]);
        }

        return response()->json(['existe' => false]);
    }
}
