<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use App\Models\Rendezvous;
use Illuminate\Http\Request;

class MairieRendezVousController extends Controller
{
    public function index(){
        $rendezvous = Rendezvous::get();
        return view('mairie.rendezvous.index', compact('rendezvous'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_mariage_souhaitee' => 'required|date',
            'heure_souhaitee' => 'required',
        ]);

        $rendezvous = Rendezvous::findOrFail($id);
        $rendezvous->date_mariage_souhaitee = $request->date_mariage_souhaitee;
        $rendezvous->heure_souhaitee = $request->heure_souhaitee;
        $rendezvous->statut = 'confirmé';
        $rendezvous->save();

        return redirect()->back()->with('success', 'Rendez-vous modifié avec succès');
    }

}
