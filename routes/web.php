<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AgentDashboard;
use App\Http\Controllers\Agent\AuthenticateAgent;
use App\Http\Controllers\Agent\Demandes\DemandeAgentController;
use App\Http\Controllers\Agent\Demandes\DemandeDecesAgentController;
use App\Http\Controllers\Agent\Demandes\DemandeHistory;
use App\Http\Controllers\Agent\Demandes\DemandeMariageAgentController;
use App\Http\Controllers\Director\AuthenticateDirector;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Director\DirectorDashboard;
use App\Http\Controllers\Director\StatistiqueController as DirectorStatistiqueController;
use App\Http\Controllers\Doctor\AuthenticateDoctor;
use App\Http\Controllers\Doctor\Deces\DeclarationDeces;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\DoctorDashboard;
use App\Http\Controllers\Doctor\Naissance\DeclarationNaissance;
use App\Http\Controllers\Doctor\StatistiqueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hopital\AuthenticateHopial;
use App\Http\Controllers\Hopital\HopialController;
use App\Http\Controllers\Hopital\StatistiqueController as HopitalStatistiqueController;
use App\Http\Controllers\Mairie\Declaration\DeclarationController;
use App\Http\Controllers\Mairie\Demandes\DemandeController;
use App\Http\Controllers\Mairie\MairieAuthenticate;
use App\Http\Controllers\Mairie\MairieController;
use App\Http\Controllers\User\Extrait\Deces\DecesCertificatController;
use App\Http\Controllers\User\Extrait\Deces\DecesSimpleConroller;
use App\Http\Controllers\User\Extrait\Mariage\MariageController;
use App\Http\Controllers\User\Extrait\Naissance\CertificatNaissance;
use App\Http\Controllers\User\Extrait\Naissance\SimpleController;
use App\Http\Controllers\User\UserAuthenticate;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\VerificationCM;
use Illuminate\Support\Facades\Route;

//Les routes de la pages d'accueil 

Route::prefix('/')->group( function(){
    Route::get('/',[HomeController::class,'home'])->name('home');
});


//Les routes de gestion users 
Route::prefix('user')->group(function(){
    Route::get('/login',[UserAuthenticate::class,'login'])->name('login');
    Route::post('/login',[UserAuthenticate::class,'handleLogin'])->name('user.handleLogin');
    Route::get('/register',[UserAuthenticate::class,'register'])->name('user.register');
    Route::post('/register',[UserAuthenticate::class,'handleRegister'])->name('user.handleRegister');
});

Route::middleware('auth')->prefix('user')->group(function(){
     Route::get('/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');
     Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

     //Les routes pour faire les demandes 
    //Les demandes d'extrait de naissance sans certificat
     Route::get('/extract/simple/index', [SimpleController::class, 'index'])->name('user.extrait.simple.index'); 
     Route::get('/extract/simple', [SimpleController::class, 'create'])->name('user.extrait.simple');
     Route::post('/extract/simple', [SimpleController::class, 'store'])->name('user.extrait.simple.store');
     Route::get('/extract/simple/delete/{naissanceD}', [SimpleController::class, 'delete'])->name('user.extrait.simple.delete');

     //Les demandes d'extrait de deces sans certificat 
     Route::get('/extract/death/index', [DecesSimpleConroller::class, 'index'])->name('user.extrait.deces.index');
     Route::get('/extract/death/simple',[DecesSimpleConroller::class,'create'])->name('user.extrait.deces.create');
     Route::post('/extract/death/simple',[DecesSimpleConroller::class,'store'])->name('user.extrait.deces.store');
     Route::get('/extract/death/certificat{decesdeja}/child', [DecesSimpleConroller::class, 'delete'])->name('user.extrait.deces.delete');
     
     //Les routes d'extrait naissance avec certificat
     Route::get('/create', [CertificatNaissance::class, 'create'])->name('user.extrait.certificat');
     Route::post('/create', [CertificatNaissance::class, 'store'])->name('user.extrait.certificat.store');
     Route::get('/naissance/delete/{naissance}', [CertificatNaissance::class, 'delete'])->name('user.extrait.certificat.delete');

    //Les routes d'extrait deces avec certificat
    Route::get('/extract/death/certificat', [DecesCertificatController::class, 'create'])->name('user.extrait.deces.certificat');
    Route::post('/extract/death/certificat', [DecesCertificatController::class, 'store'])->name('user.extrait.deces.certificat.store');
    Route::get('/extract/death/certificat{deces}', [DecesCertificatController::class, 'delete'])->name('user.extrait.deces.certificat.delete');

    //Les routes d'extrait de mariage
    Route::get('/wedding/index', [MariageController::class, 'index'])->name('user.extrait.mariage.index');
    Route::get('/create/wedding', [MariageController::class, 'create'])->name('user.extrait.mariage.create');
    Route::post('/create/wedding', [MariageController::class, 'store'])->name('user.extrait.mariage.store');
    Route::get('/wedding/delete/{mariage}', [MariageController::class, 'delete'])->name('user.extrait.mariage.delete');
    


     //La route de verification du CMN
     Route::post('/verifier-code-dm', [VerificationCM::class, 'verifierCMN'])->name('code.verifie.cmn');
     Route::post('/deces/verifierCodeCMD', [VerificationCM::class, 'verifierCMD'])->name('code.verifie.cmd');
     
});


//Les routes de gestion de la mairie
Route::prefix('mairie')->group(function(){
    Route::get('/login',[MairieAuthenticate::class,'login'])->name('mairie.login');
    Route::post('/login',[MairieAuthenticate::class,'handleLogin'])->name('mairie.handleLogin');
});

Route::middleware('mairie')->prefix('mairie')->group(function(){
     Route::get('/dashboard',[MairieController::class,'dashboard'])->name('mairie.dashboard');
     Route::get('/logout', [MairieController::class, 'logout'])->name('mairie.logout');

     //routes des gestion des hopitaux par la mairie 
    Route::prefix('hopital')->group(function(){
        Route::get('/create',[HopialController::class, 'create'])->name('hopital.create');
        Route::get('/index',[HopialController::class, 'index'])->name('hopital.index');
        Route::post('/create',[HopialController::class, 'store'])->name('hopital.store');
    });

    //Les routes de gestion des agents d'état civil 
    Route::prefix('agent')->group(function(){
        Route::get('/', [AgentController::class, 'index'])->name('agent.index');
        Route::get('/create', [AgentController::class, 'create'])->name('agent.create');
        Route::post('/create', [AgentController::class, 'store'])->name('agent.store');
    });

    //Les routes de gestions des arrivées des demandes naissance, deces et mariages
     Route::get('/all/requests/birth', [DemandeController::class, 'index'])->name('mairie.demandes.naissance.index'); 
     Route::get('/all/requests/death', [DemandeController::class, 'indexDeces'])->name('mairie.demandes.deces.index');  
     Route::get('/all/requests/wedding', [DemandeController::class, 'indexWedding'])->name('mairie.demandes.wedding.index');  


     //les routes de gestions des arrivées des declarations naissance et deces 
     Route::get('/statement/birth', [DeclarationController::class, 'naissance'])->name('mairie.declaration.naissance.index');
     Route::get('/death/statementde', [DeclarationController::class, 'deces'])->name('mairie.declaration.deces.index');
});


//Les routes de gestions de l'hopital
Route::prefix('hopital')->group(function() {
    Route::get('/login', [AuthenticateHopial::class, 'login'])->name('hopital.login');
    Route::post('/login', [AuthenticateHopial::class, 'handleLogin'])->name('hopital.handleLogin');
});

Route::middleware('hopital')->prefix('hopital')->group(function(){
     Route::get('/dashboard',[HopialController::class,'dashboard'])->name('hopital.dashboard');
     Route::get('/logout', [HopialController::class, 'logout'])->name('hopital.logout');

     //Les routes de gestion des personnels par l'hopital 
     Route::prefix('personal')->group(function(){
        Route::get('/index',[DoctorController::class, 'index'])->name('doctor.index');
        Route::get('/create',[DoctorController::class, 'create'])->name('doctor.create');
        Route::post('/create',[DoctorController::class, 'store'])->name('doctor.store');
        Route::get('/edit/{doctor}',[DoctorController::class, 'edit'])->name('doctor.edit');
        Route::put('/edit/{doctor}',[DoctorController::class, 'update'])->name('doctor.update');
        Route::delete('/delete/{doctor}',[DoctorController::class, 'delete'])->name('doctor.delete');
     });

     //Les routes de gestion des directeurs de l'hopital par l'hopital
     Route::prefix('director')->group(function(){
         Route::get('/create-director',[DirectorController::class, 'create'])->name('directeur.create');
         Route::post('/create-director',[DirectorController::class, 'store'])->name('directeur.store');
         Route::get('/edit-director/{director}',[DirectorController::class, 'edit'])->name('directeur.edit');
         Route::put('/edit-director/{director}',[DirectorController::class, 'update'])->name('directeur.update');
         Route::get('/delete-director/{director}',[DirectorController::class, 'delete'])->name('directeur.delete');
     });

     //Les routes de statistiques 
     Route::get('/stat', [HopitalStatistiqueController::class, 'index'])->name('hopital.stat');
     Route::get('/stat/download', [HopitalStatistiqueController::class, 'download'])->name('hopital.download.stat');
});


//Les routes de gestions des personnels
Route::prefix('doctor')->group(function() {
    Route::get('/login', [AuthenticateDoctor::class, 'login'])->name('doctor.login');
    Route::post('/login', [AuthenticateDoctor::class, 'handleLogin'])->name('doctor.handleLogin');
});

Route::middleware('doctor')->prefix('doctor')->group(function(){
     Route::get('/dashboard',[DoctorDashboard::class,'dashboard'])->name('doctor.dashboard');
     Route::get('/logout', [DoctorDashboard::class, 'logout'])->name('doctor.logout');

     //Les routes pour les declarations de naissance 
      Route::prefix('statement')->group(function () {
        Route::get('/indexbirth', [DeclarationNaissance::class, 'index'])->name('statement.index');
        Route::get('/birth/createbirth', [DeclarationNaissance::class, 'create'])->name('statement.create');
        Route::post('/birth/create', [DeclarationNaissance::class, 'store'])->name('statement.store');
        Route::get('/birth/editbirth/{naisshop}', [DeclarationNaissance::class, 'edit'])->name('statement.edit');
        Route::put('/birth/editbirth/{naisshop}', [DeclarationNaissance::class, 'update'])->name('statement.update');
        Route::get('/birth/delete/{naisshop}', [DeclarationNaissance::class, 'delete'])->name('statement.delete');
        Route::get('/birth/download/{id}', [DeclarationNaissance::class, 'download'])->name('statement.download');
        Route::get('/showbirth/{id}', [DeclarationNaissance::class, 'show'])->name('statement.show');
        Route::get('/mairie/{id}', [DeclarationNaissance::class, 'mairieshow'])->name('naissHopmairie.show');
    });

     //Les routes pour les declarations de naissance 
      Route::prefix('statement')->group(function () {
        Route::get('/death', [DeclarationDeces::class, 'index'])->name('statement.index.death');
        Route::get('/death/createdeath', [DeclarationDeces::class, 'create'])->name('statement.create.death');
        Route::post('/death/create', [DeclarationDeces::class, 'store'])->name('statement.store.death');
        Route::get('/death/edit/{deceshop}', [DeclarationDeces::class, 'edit'])->name('statement.edit.death');
        Route::put('/death/edit/{deceshop}', [DeclarationDeces::class, 'update'])->name('statement.update.death');
        Route::get('/death/delete/{deceshop}', [DeclarationDeces::class, 'delete'])->name('statement.delete.death');
        Route::get('/death/download/{id}', [DeclarationDeces::class, 'download'])->name('statement.download.death');
        Route::get('/download-contagion/{id}', [DeclarationDeces::class, 'downloadcontagion'])->name('statement.downloadcontagion.death');
        Route::get('/death/{id}', [DeclarationDeces::class, 'show'])->name('statement.show.death');
        Route::get('/mairie/{id}', [DeclarationDeces::class, 'mairieshow'])->name('naissHopmairie.show.death');
    });
    
    //Les routes de statistique du docteur
    Route::get('/stat', [StatistiqueController::class, 'statistique'])->name('doctor.stat');
    Route::get('/download', [StatistiqueController::class, 'download'])->name('doctor.download.stat');

    //La route pour enregistré sa signature
    Route::get('/signature',[StatistiqueController::class, 'signature'])->name('doctor.signature');
    Route::post('/signature/update',[StatistiqueController::class, 'updateSignature'])->name('doctor.signature.update'); 
});


//Les routes de gestions des directeurs 
Route::prefix('director')->group(function() {
    Route::get('/login', [AuthenticateDirector::class, 'login'])->name('directeur.login');
    Route::post('/login', [AuthenticateDirector::class, 'handleLogin'])->name('directeur.handleLogin');
});

Route::middleware('director')->prefix('director')->group(function(){
     Route::get('/dashboard',[DirectorDashboard::class,'dashboard'])->name('directeur.dashboard');
     Route::get('/doctor/personal',[DirectorDashboard::class, 'doctor'])->name('directeur.doctor');
     Route::get('/director/birth',[DirectorDashboard::class, 'birth'])->name('directeur.birth');
     Route::get('/director/death',[DirectorDashboard::class, 'death'])->name('directeur.death');
     Route::get('/logout', [DirectorDashboard::class, 'logout'])->name('directeur.logout');

     //Les routes des statistiques
     Route::get('/stat', [DirectorStatistiqueController::class, 'index'])->name('directeur.index.stat');
     Route::get('/director/download', [DirectorStatistiqueController::class, 'download'])->name('directeur.download.stat');
});

//Les routes de gestion des agents
Route::prefix('agent')->group(function() {
    Route::get('/login', [AuthenticateAgent::class, 'login'])->name('agent.login');
    Route::post('/login', [AuthenticateAgent::class, 'handleLogin'])->name('agent.handleLogin');
});

Route::middleware('auth:agent')->prefix('agent')->group(function(){
        Route::get('/dashboard', [AgentDashboard::class, 'dashboard'])->name('agent.dashboard');
        Route::get('/logout', [AgentController::class, 'logout'])->name('agent.logout');

        //La route de declaration de naissance 
        Route::get('/birth/statemente', [DemandeAgentController::class, 'declarationNaissance'])->name('agent.declaration.naissance.index');
        Route::get('/death/statementd', [DemandeDecesAgentController::class, 'declarationDeces'])->name('agent.declaration.deces.index');

        //Les routes des demandes recuperer de naissance
        Route::get('/all/requests/birth', [DemandeAgentController::class, 'index'])->name('agent.demandes.naissance.index');
        Route::get('/naissance/{id}/edit', [DemandeAgentController::class, 'edit'])->name('agent.demandes.naissance.edit');
        Route::post('/naissance/{id}/update-etat', [DemandeAgentController::class, 'updateEtat'])->name('agent.demandes.naissance.update');
        Route::post('/{naissance}/annuler', [AgentController::class, 'annuler'])->name('agent.demandes.naissance.annuler');
        Route::get('/naissanced/{id}/edit', [DemandeAgentController::class, 'editSimple'])->name('agent.demandes.naissance.edit.simple');
        Route::post('/naissanced/{id}/update-etat', [DemandeAgentController::class, 'updateEtatSimple'])->name('agent.demandes.naissance.update.simple');


        //Les routes des demandes recuperer de deces 
        Route::get('/all/requests/death', [DemandeDecesAgentController::class, 'index'])->name('agent.demandes.deces.index');
        Route::get('/deces/{id}/edit', [DemandeDecesAgentController::class, 'edit'])->name('agent.demandes.deces.edit'); 
        Route::post('/deces/{id}/update-etat', [DemandeDecesAgentController::class, 'updateEtat'])->name('agent.demandes.deces.update');
        Route::get('/decesdeja/{id}/edit', [DemandeDecesAgentController::class, 'editSimple'])->name('agent.demandes.deces.edit.simple');
        Route::post('/decesdeja/{id}/update-etat', [DemandeDecesAgentController::class, 'updateEtatSimple'])->name('agent.demandes.deces.update.simple');


        //Les routes des demandes recuperer mariages
        Route::get('/all/requests/wedding', [DemandeMariageAgentController::class, 'index'])->name('agent.demandes.wedding.index');
        Route::get('/mariage/{id}/edit', [DemandeMariageAgentController::class, 'edit'])->name('agent.demandes.wedding.edit');
        Route::post('/mariage/{id}/update-etat', [DemandeMariageAgentController::class, 'updateEtat'])->name('agent.demandes.wedding.update');  

        //les routes pour la recuperation des demandes 
        Route::post('/naissance/traiter/{id}', [AgentDashboard::class, 'traiterDemande'])->name('naissance.traiter');
        Route::post('/deces/traiter/{id}', [AgentDashboard::class, 'traiterDemandeDeces'])->name('deces.traiter');
        Route::post('/mariage/traiter/{id}', [AgentDashboard::class, 'traiterDemandeMariage'])->name('mariage.traiter');

        //Historiques des traitements effectuer par l'agent 
        Route::get('/task/end/naissance',[DemandeHistory::class, 'taskend'])->name('agent.history.taskend');
        Route::get('/task/end/deces',[DemandeHistory::class, 'taskenddeces'])->name('agent.history.taskenddeces');
});


//Les routes definition du accès 
Route::get('/validate-hopital-account/{email}', [AuthenticateHopial::class, 'defineAccess']);
Route::post('/validate-hopital-account/{email}', [AuthenticateHopial::class, 'submitDefineAccess'])->name('hopital.validate');
Route::get('/validate-account/{email}', [AuthenticateDoctor::class, 'defineAccess']);
Route::post('/validate-account/{email}', [AuthenticateDoctor::class, 'submitDefineAccess'])->name('doctor.validate');
Route::get('/validate-director-account/{email}', [AuthenticateDirector::class, 'defineAccess']);
Route::post('/validate-director-account/{email}', [AuthenticateDirector::class, 'submitDefineAccess'])->name('directeur.validate');
Route::get('/validate-agent-account/{email}', [AuthenticateAgent::class, 'defineAccess']);
Route::post('/validate-agent-account/{email}', [AuthenticateAgent::class, 'submitDefineAccess'])->name('agent.validate');
 

