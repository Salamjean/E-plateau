<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\ResetCodePassword;
use App\Notifications\SendEmailToDoctorAfterRegistrationNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DoctorController extends Controller
{
    public function create(){
        $sanitaires = DB::table('sanitaires')->pluck('name_hospial');
        return view('hopital.doctor.create',compact('sanitaires'));
    }
    public function store(DoctorRequest $request)
    {
        try {
            // Récupérer le docteur connecté
            $hopital = Auth::guard('hopital')->user(); // Assurez-vous que le docteur est authentifié via `auth`
    
            if (!$hopital || !$hopital->nomHop || !$hopital->commune) {
                return redirect()->back()->withErrors(['error' => 'Impossible de récupérer le nom de l\'hôpital.']);
            }
    
            // Création du sous-admin
            $doctor = new Doctor();
            $doctor->name = $request->name;
            $doctor->prenom = $request->prenom;
            $doctor->email = $request->email;
            $doctor->description = $request->description;
            $doctor->password = Hash::make('default');
            $doctor->contact = $request->contact;
            $doctor->fonction = $request->fonction;
            $doctor->sexe = $request->sexe;
            $doctor->profile_picture = $request->profile_picture;
            $doctor->nomHop = $hopital->nomHop; // Associe le même nomHop que le docteur
            $doctor->commune = $hopital->commune; // Associe la commune du docteur
            $doctor->save();
    
            // Envoi de l'e-mail de vérification
            if ($doctor) {
                try {
                    ResetCodePassword::where('email', $doctor->email)->delete();
                    $code = rand(1000, 4000);
    
                    $data = [
                        'code' => $code,
                        'email' => $doctor->email,
                    ];
    
                    ResetCodePassword::create($data);
    
                    Notification::route('mail', $doctor->email)
                        ->notify(new SendEmailToDoctorAfterRegistrationNotification($code, $doctor->email));
    
                    return redirect()->route('doctor.index')->with('success', 'personnel inscrire avec succès.');

                } catch (Exception $e) {
                    throw new Exception('Une erreur est survenue lors de l\'envoi de l\'e-mail.');
                }
            }
        } catch (Exception $e) {
            Log::error('Erreur création docteur: ' . $e->getMessage());
            throw new Exception('Une erreur est survenue lors de la création du docteur.');
        }
    }

    public function index() {
        // Récupérer l'administrateur connecté
        $hopital = Auth::guard('hopital')->user();
        
        // Récupérer la commune de l'administrateur
        $communeHopital = $hopital->nomHop;
    
        // Récupérer les sous-administrateurs filtrés par la commune
        $doctors = Doctor::whereNull('archived_at')
            ->where('nomHop', $communeHopital)
            ->paginate(10);
    
        return view('hopital.doctor.index', compact('doctors'));
    }

    public function edit(Doctor $doctor){
         $sanitaires = DB::table('sanitaires')->pluck('name_hospial');
        return view('hopital.doctor.edit', compact('doctor','sanitaires'));
    }

    public function update(UpdateDoctorRequest $request,Doctor $doctor){
        try {
            $doctor->name = $request->name;
            $doctor->prenom = $request->prenom;
            $doctor->email = $request->email;
            $doctor->description = $request->description;
            $doctor->contact = $request->contact;
            $doctor->sexe = $request->sexe;
            $doctor->fonction = $request->fonction;
            $doctor->update();

            return redirect()->route('doctor.index')->with('success','Les informations du personnel ont été mises à jour avec succès.');
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('error','Une erreur est survenue lors de la modification du personnel');
        }
    }

    public function delete(Doctor $doctor){
        try {
            $doctor->archive();
            return redirect()->route('doctor.index')->with('success1','Le personnel a été supprimé avec succès.');
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('error','Une erreur est survenue lors de la suppression du personnel');
        }
    }
}
