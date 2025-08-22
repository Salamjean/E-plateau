<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgentAdminController;
use App\Http\Controllers\Admin\AuthenticateAdmin;
use App\Http\Controllers\Admin\DemandesDeclarationsController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AgentDashboard;
use App\Http\Controllers\Agent\AuthenticateAgent;
use App\Http\Controllers\Agent\Demandes\DemandeAgentController;
use App\Http\Controllers\Agent\Demandes\DemandeDecesAgentController;
use App\Http\Controllers\Agent\Demandes\DemandeHistory;
use App\Http\Controllers\Agent\Demandes\DemandeMariageAgentController;
use App\Http\Controllers\Caisse\AuthenticateCaisse;
use App\Http\Controllers\Caisse\CaisseController;
use App\Http\Controllers\Caisse\CaisseDashboard;
use App\Http\Controllers\Delivery\AuthenticateDelivery;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Delivery\DeliveryDashboard;
use App\Http\Controllers\Delivery\LivraisonDelivery;
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
use App\Http\Controllers\Hopital\AddHopitalController;
use App\Http\Controllers\Hopital\AuthenticateHopial;
use App\Http\Controllers\Hopital\HopialController;
use App\Http\Controllers\Hopital\StatistiqueController as HopitalStatistiqueController;
use App\Http\Controllers\Poste\LivraisonExtraitController;
use App\Http\Controllers\Mairie\Declaration\DeclarationController;
use App\Http\Controllers\Mairie\Demandes\DemandeController;
use App\Http\Controllers\Mairie\Demandes\Demandeshistory;
use App\Http\Controllers\Mairie\MairieAuthenticate;
use App\Http\Controllers\Mairie\MairieController;
use App\Http\Controllers\Mairie\MairieRendezVousController;
use App\Http\Controllers\Poste\AuthenticatePoste;
use App\Http\Controllers\Poste\PosteController;
use App\Http\Controllers\Poste\PosteDashboard;
use App\Http\Controllers\User\Extrait\Deces\DecesCertificatController;
use App\Http\Controllers\User\Extrait\Deces\DecesSimpleConroller;
use App\Http\Controllers\User\Extrait\Mariage\MariageController;
use App\Http\Controllers\User\Extrait\Naissance\CertificatNaissance;
use App\Http\Controllers\User\Extrait\Naissance\SimpleController;
use App\Http\Controllers\User\RendezVousController;
use App\Http\Controllers\User\UserAuthenticate;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\VerificationCM;
use Illuminate\Support\Facades\Route;

//Les routes de la pages d'accueil 

Route::prefix('/')->group( function(){
    Route::get('/',[HomeController::class,'home'])->name('home');
    Route::match(['get', 'post'], 'home/search', [HomeController::class, 'recherche'])->name('recherche.demande');
    Route::get('home/about', [HomeController::class, 'about'])->name('about.demande');
    Route::get('home/service', [HomeController::class, 'service'])->name('service.demande');
    Route::get('home/department', [HomeController::class, 'department'])->name('department.demande');

    //Les routes des actes civils 
    Route::get('home/birth', [HomeController::class, 'birth'])->name('home.birth');
    Route::get('home/death', [HomeController::class, 'death'])->name('home.death');
    Route::get('home/wedding', [HomeController::class, 'wedding'])->name('home.wedding');
    Route::get('home/rendezvous', [HomeController::class, 'rendezvous'])->name('home.rendezvous');
    Route::get('home/contact', [HomeController::class, 'contact'])->name('home.contact');
});

//Les routes de gestion du @super admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthenticateAdmin::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthenticateAdmin::class, 'handleLogin'])->name('admin.handleLogin');
});

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    //Les routes de gestion de la mairie par l'admin
    Route::prefix('mairie')->group(function(){
        Route::get('/index', [MairieController::class, 'index'])->name('admin.index');
        Route::get('/index/archive', [MairieController::class, 'archive'])->name('admin.archive');
        Route::get('/create', [MairieController::class, 'create'])->name('admin.create');
        Route::post('/store', [MairieController::class, 'store'])->name('admin.store');
        Route::post('/add-solde', [MairieController::class, 'addSolde'])->name('admin.add_solde');

        Route::delete('/{vendor}/archive', [MairieController::class, 'archive'])->name('vendor.archive');
        Route::put('/mairie/unarchive/{id}', [MairieController::class, 'unarchive'])->name('mairie.unarchive');
        Route::delete('/{vendor}/delete', [MairieController::class, 'vendordelete'])->name('vendor.delete');
    });

    //Les routes de gestions de demandes et declarations par l'admin
    Route::get('/birth/request', [DemandesDeclarationsController::class, 'naissance'])->name('admin.demandes.naissance');
    Route::get('/death/request', [DemandesDeclarationsController::class, 'deces'])->name('admin.demandes.deces');
    Route::get('/wedding/request', [DemandesDeclarationsController::class, 'mariage'])->name('admin.demandes.mariage');
    Route::get('/birth/statement', [DemandesDeclarationsController::class, 'declarationNaissance'])->name('admin.declaration.naissance');
    Route::get('death/statement', [DemandesDeclarationsController::class, 'declarationDeces'])->name('admin.declaration.deces');

    //les routes de gestions des personnels par l'admin
    Route::get('/agent/all', [AgentAdminController::class, 'agent'])->name('admin.agent');
    Route::get('/personal/all', [AgentAdminController::class, 'personal'])->name('admin.personal');
    Route::get('/caisse/all', [AgentAdminController::class, 'caisse'])->name('admin.caisse');


});        



//Les routes de gestion @users 
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
     Route::post('/update/prenom/{id}', [CertificatNaissance::class, 'updateprenom'])->name('modifier.prenom');

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


     //Les routes pour prendre un rendez-vous de mariage
        Route::get('/rendezvous/index', [RendezvousController::class, 'index'])->name('user.rendezvous.index');
        Route::get('/rendezvous/create', [RendezvousController::class, 'create'])->name('user.rendezvous.create');
        Route::post('/rendezvous', [RendezvousController::class, 'store'])->name('user.rendezvous.store');

    //la route de gestion des historiques 
        Route::get('/history/ends',[UserAuthenticate::class,'history'])->name('user.history');
        Route::get('/demande-details/{type}/{id}', [UserAuthenticate::class, 'getDemandeDetails'])->name('demande.details.json');
});


//Les routes de gestion de la @mairie
Route::prefix('mairie')->group(function(){
    Route::get('/login',[MairieAuthenticate::class,'login'])->name('mairie.login');
    Route::post('/login',[MairieAuthenticate::class,'handleLogin'])->name('mairie.handleLogin');
});

Route::middleware('mairie')->prefix('mairie')->group(function(){
     Route::get('/dashboard',[MairieController::class,'dashboard'])->name('mairie.dashboard');
     Route::get('/logout', [MairieController::class, 'logout'])->name('mairie.logout');

     //routes des gestion des hopitaux par la mairie 
    Route::prefix('hopital')->group(function(){
        Route::get('/hoscreate',[HopialController::class, 'create'])->name('hopital.create');
        Route::get('/hosindex',[HopialController::class, 'index'])->name('hopital.index');
        Route::post('/create',[HopialController::class, 'store'])->name('hopital.store');
        Route::get('hopital/{id}/edit', [HopialController::class, 'edit'])->name('hopital.edit');
        Route::put('hopital/{id}', [HopialController::class, 'update'])->name('hopital.update');
        Route::delete('hopital/{id}', [HopialController::class, 'destroy'])->name('hopital.destroy');
    });

    //Les routes de gestion des agents d'état civil 
    Route::prefix('agent')->group(function(){
        Route::get('/', [AgentController::class, 'index'])->name('agent.index');
        Route::get('/createadd', [AgentController::class, 'create'])->name('agent.create');
        Route::post('/create', [AgentController::class, 'store'])->name('agent.store');
        Route::get('/{id}/edit', [AgentController::class, 'edit'])->name('agent.edit');
        Route::put('/{id}', [AgentController::class, 'update'])->name('agent.update');
        Route::delete('delete/{id}', [AgentController::class, 'destroy'])->name('agent.destroy');
    });

    //Les routes de gestion de la caisse de la mairie
    Route::prefix('cash')->group(function(){
        Route::get('/indexcash', [CaisseController::class, 'index'])->name('caisse.index');
        Route::get('/createcash', [CaisseController::class, 'create'])->name('caisse.create');
        Route::post('/create', [CaisseController::class, 'store'])->name('caisse.store');
        Route::get('/{caisse}/edit', [CaisseController::class, 'edit'])->name('caisse.edit');
    });

    //Les routes de gestion de la caisse de la mairie
    Route::prefix('post')->group(function(){
        Route::get('/indexpost', [PosteController::class, 'index'])->name('post.index');
        Route::get('/createpost', [PosteController::class, 'create'])->name('post.create');
        Route::post('/create', [PosteController::class, 'store'])->name('post.store');
        Route::get('/{post}/edit', [PosteController::class, 'edit'])->name('post.edit');
    });

     //Les routes de gestions des arrivées des demandes naissance, deces et mariages
     Route::get('/all/requests/birth', [DemandeController::class, 'index'])->name('mairie.demandes.naissance.index'); 
     Route::get('/all/requests/death', [DemandeController::class, 'indexDeces'])->name('mairie.demandes.deces.index');  
     Route::get('/all/requests/wedding', [DemandeController::class, 'indexWedding'])->name('mairie.demandes.wedding.index');  


     //les routes de gestions des arrivées des declarations naissance et deces 
     Route::get('/statement/birth', [DeclarationController::class, 'naissance'])->name('mairie.declaration.naissance.index');
     Route::get('/death/statementde', [DeclarationController::class, 'deces'])->name('mairie.declaration.deces.index');

     //Historiques des demandes 
     Route::get('/task/end/naissance',[Demandeshistory::class, 'taskend'])->name('mairie.history.taskend');
     Route::get('/task/end/deces',[Demandeshistory::class, 'taskenddeces'])->name('mairie.history.taskenddeces');
     Route::get('/task/end/mariages',[Demandeshistory::class, 'taskendmariages'])->name('mairie.history.taskendmariages');

     //Les routes de gestion des rendez-vous par la mairie 
     Route::get('/rendezvous/index', [MairieRendezVousController::class, 'index'])->name('mairie.rendezvous.index');
     Route::put('/rendezvous/{id}', [MairieRendezVousController::class, 'update'])->name('rendezvous.update');
     Route::post('/mairie/rendezvous/{id}/confirm', [MairieRendezVousController::class, 'confirm'])->name('rendezvous.confirm');
     Route::get('/rendezvous/{id}/confirmation', [MairieRendezVousController::class, 'confirmation'])->name('rendezvous.confirmation');

});


//Les routes de gestions de l'@hopital
Route::prefix('hopital')->group(function() {
    Route::get('/login', [AuthenticateHopial::class, 'login'])->name('hopital.login');
    Route::post('/login', [AuthenticateHopial::class, 'handleLogin'])->name('hopital.handleLogin');
});

Route::middleware('hopital')->prefix('hopital')->group(function(){
     Route::get('/dashboard',[HopialController::class,'dashboard'])->name('hopital.dashboard');
     Route::get('/logout', [HopialController::class, 'logout'])->name('hopital.logout');

     //Les routes pour les ajouts des sanitaires
     Route::prefix('sanitary')->group(function(){
        Route::get('/indexsanitary',[AddHopitalController::class,'index'])->name('sanitary.index');
        Route::get('/createsanitary',[AddHopitalController::class,'create'])->name('sanitary.create');
        Route::post('/createsanitary',[AddHopitalController::class,'store'])->name('sanitary.store');
     });

     //Les routes de gestion des personnels par l'hopital 
     Route::prefix('personal')->group(function(){
        Route::get('/indexperso',[DoctorController::class, 'index'])->name('doctor.index');
        Route::get('/createperso',[DoctorController::class, 'create'])->name('doctor.create');
        Route::post('/create',[DoctorController::class, 'store'])->name('doctor.store');
        Route::get('/edit/{doctor}/editperso',[DoctorController::class, 'edit'])->name('doctor.edit');
        Route::put('/edit/{doctor}',[DoctorController::class, 'update'])->name('doctor.update');
        Route::delete('/delete/{doctor}',[DoctorController::class, 'delete'])->name('doctor.delete');
     });

     //Les routes de gestion des directeurs de l'hopital par l'hopital
     Route::prefix('director')->group(function(){
         Route::get('/create-director',[DirectorController::class, 'create'])->name('directeur.create');
         Route::post('/create-director',[DirectorController::class, 'store'])->name('directeur.store');
         Route::get('/edit-director/{director}/editdire',[DirectorController::class, 'edit'])->name('directeur.edit');
         Route::put('/edit-director/{director}',[DirectorController::class, 'update'])->name('directeur.update');
         Route::get('/delete-director/{director}',[DirectorController::class, 'delete'])->name('directeur.delete');
     });

     //Les routes de statistiques 
     Route::get('/stat', [HopitalStatistiqueController::class, 'index'])->name('hopital.stat');
     Route::get('/stat/download', [HopitalStatistiqueController::class, 'download'])->name('hopital.download.stat');
});


//Les routes de gestions des @personnels
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
        Route::get('/birth/{naisshop}/editbirth', [DeclarationNaissance::class, 'edit'])->name('statement.edit');
        Route::put('/birth/editbirth/{naisshop}', [DeclarationNaissance::class, 'update'])->name('statement.update');
        Route::get('/birth/delete/{naisshop}', [DeclarationNaissance::class, 'delete'])->name('statement.delete');
        Route::get('/birth/download/{id}', [DeclarationNaissance::class, 'download'])->name('statement.download');
        Route::get('/show/{id}/birthed', [DeclarationNaissance::class, 'show'])->name('statement.show');
        Route::get('/mairie/{id}', [DeclarationNaissance::class, 'mairieshow'])->name('naissHopmairie.show');
    });

     //Les routes pour les declarations de naissance 
      Route::prefix('statement')->group(function () {
        Route::get('/death', [DeclarationDeces::class, 'index'])->name('statement.index.death');
        Route::get('/death/createdeath', [DeclarationDeces::class, 'create'])->name('statement.create.death');
        Route::post('/death/create', [DeclarationDeces::class, 'store'])->name('statement.store.death');
        Route::get('/death/{deceshop}/editdeath', [DeclarationDeces::class, 'edit'])->name('statement.edit.death');
        Route::put('/death/edit/{deceshop}', [DeclarationDeces::class, 'update'])->name('statement.update.death');
        Route::get('/death/delete/{deceshop}', [DeclarationDeces::class, 'delete'])->name('statement.delete.death');
        Route::get('/death/download/{id}', [DeclarationDeces::class, 'download'])->name('statement.download.death');
        Route::get('/download-contagion/{id}', [DeclarationDeces::class, 'downloadcontagion'])->name('statement.downloadcontagion.death');
        Route::get('/death/{id}/deathed', [DeclarationDeces::class, 'show'])->name('statement.show.death');
        Route::get('/mairie/{id}', [DeclarationDeces::class, 'mairieshow'])->name('naissHopmairie.show.death');
    });
    
    //Les routes de statistique du docteur
    Route::get('/stat', [StatistiqueController::class, 'statistique'])->name('doctor.stat');
    Route::get('/download', [StatistiqueController::class, 'download'])->name('doctor.download.stat');

    //La route pour enregistré sa signature
    Route::get('/signature',[StatistiqueController::class, 'signature'])->name('doctor.signature');
    Route::post('/signature/update',[StatistiqueController::class, 'updateSignature'])->name('doctor.signature.update'); 
});


//Les routes de gestions des @directeurs 
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

//Les routes de gestion des @agents
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
        Route::post('/demandes/deces/{id}/initier-livraison', [DemandeDecesAgentController::class, 'initierLivraison'])->name('agent.demandes.deces.initier-livraison');


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
        Route::get('/task/end/mariages',[DemandeHistory::class, 'taskendmariages'])->name('agent.history.taskendmariages');

        //Routes pour avoir la liste des livreurs par l'agent
        Route::get('/delivery/index',[AgentController::class,'delivery'])->name('agent.delivery');
});

//Les routes de getsion de @caisses 
Route::prefix('caisse')->group(function() {
    Route::get('/login', [AuthenticateCaisse::class, 'login'])->name('caisse.login');
    Route::post('/login', [AuthenticateCaisse::class, 'handleLogin'])->name('caisse.handleLogin');
});

Route::middleware('auth:caisse')->prefix('caisse')->group(function(){
    Route::get('/dahboard', [CaisseDashboard::class, 'dashboard'])->name('caisse.dashboard');
    Route::get('/logout', [CaisseDashboard::class, 'logout'])->name('caisse.logout');
});


//Les routes de getsion de @postes 
Route::prefix('post')->group(function() {
    Route::get('/login', [AuthenticatePoste::class, 'login'])->name('post.login');
    Route::post('/login', [AuthenticatePoste::class, 'handleLogin'])->name('post.handleLogin');
});

Route::middleware('auth:poste')->prefix('post')->group(function(){
    Route::get('/dahboard', [PosteDashboard::class, 'dashboard'])->name('post.dashboard');
    Route::get('/logout', [PosteDashboard::class, 'logout'])->name('post.logout');

    //La route des demandes à livrer
    Route::prefix('livraison')->group(function () {
        Route::get('/createed', [LivraisonExtraitController::class, 'create'])->name('livraison.create');
        Route::post('/posted/attribuer-demande', [LivraisonExtraitController::class, 'attribuerDemande'])->name('poste.attribuer-demande');
        Route::get('/poste/demandes-attribuees', [LivraisonExtraitController::class, 'demandesAttribuees'])->name('poste.demandes-attribuees');
        Route::get('/poste/demandes-livree', [LivraisonExtraitController::class, 'demandesLivree'])->name('poste.demandes-livree');
        Route::post('/poste/assigner-livreur', [LivraisonExtraitController::class, 'assignerLivreur'])->name('poste.assigner-livreur');
    });

    //Gestion des livreurs par la poste 
    Route::prefix('delivery')->group(function(){
        Route::get('/index',[DeliveryController::class, 'index'])->name('delivery.index');
        Route::get('/create',[DeliveryController::class, 'create'])->name('delivery.create');
        Route::post('/create',[DeliveryController::class, 'store'])->name('delivery.store');
        Route::get('/edit/{delivery}',[DeliveryController::class, 'edit'])->name('delivery.edit');
        Route::put('/edit/{delivery}',[DeliveryController::class, 'update'])->name('delivery.update');
        Route::delete('/delete/{delivery}',[DeliveryController::class, 'delete'])->name('delivery.delete');
    });
});

//Les routes de getsion de @livreur 
Route::prefix('delivery')->group(function() {
    Route::get('/login', [AuthenticateDelivery::class, 'login'])->name('delivery.login');
    Route::post('/login', [AuthenticateDelivery::class, 'handleLogin'])->name('delivery.handleLogin');
});

Route::middleware('auth:livreur')->prefix('delivery')->group(function(){
    Route::get('/dahboard', [DeliveryDashboard::class, 'dashboard'])->name('delivery.dashboard');
    Route::get('/logout', [DeliveryDashboard::class, 'logout'])->name('delivery.logout');
    Route::post('/livreur/toggle-disponibilite', [DeliveryDashboard::class, 'toggleDisponibilite'])->name('livreur.toggleDisponibilite');

    //Gestion des livraison par le livreur
    Route::get('/livraison',[LivraisonDelivery::class,'delivery'])->name('livreur.livraison');
    Route::get('/delivery/livree',[LivraisonDelivery::class,'livree'])->name('livreur.livree');

    Route::get('/livraison/validate', [LivraisonDelivery::class, 'validated'])->name('livreur.validated');
    Route::post('/livraison/validate', [LivraisonDelivery::class, 'validated']);
    Route::post('/check-reference', [LivraisonDelivery::class, 'checkReference'])->name('livreur.check-reference');
    
    
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
Route::get('/validate-caisse-account/{email}', [AuthenticateCaisse::class, 'defineAccess']);
Route::post('/validate-caisse-account/{email}', [AuthenticateCaisse::class, 'submitDefineAccess'])->name('caisse.validate');
Route::get('/validate-mairie-account/{email}', [MairieAuthenticate::class, 'defineAccess']);
Route::post('/validate-mairie-account/{email}', [MairieAuthenticate::class, 'submitDefineAccess'])->name('mairie.validate');
Route::get('/validate-post-account/{email}', [AuthenticatePoste::class, 'defineAccess']);
Route::post('/validate-post-account/{email}', [AuthenticatePoste::class, 'submitDefineAccess'])->name('post.validate');
Route::get('/validate-delivery-account/{email}', [AuthenticateDelivery::class, 'defineAccess']);
Route::post('/validate-delivery-account/{email}', [AuthenticateDelivery::class, 'submitDefineAccess'])->name('delivery.validate');
 

