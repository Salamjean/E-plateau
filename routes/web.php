<?php

use App\Http\Controllers\Director\AuthenticateDirector;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Director\DirectorDashboard;
use App\Http\Controllers\Doctor\AuthenticateDoctor;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\DoctorDashboard;
use App\Http\Controllers\Doctor\Naissance\DeclarationNaissance;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hopital\AuthenticateHopial;
use App\Http\Controllers\Hopital\HopialController;
use App\Http\Controllers\Mairie\MairieAuthenticate;
use App\Http\Controllers\Mairie\MairieController;
use App\Http\Controllers\User\UserAuthenticate;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

//Les routes de la pages d'accueil 

Route::prefix('/')->group( function(){
    Route::get('/',[HomeController::class,'home'])->name('home');
});


//Les routes de gestion users 
Route::prefix('user')->group(function(){
    Route::get('/login',[UserAuthenticate::class,'login'])->name('user.login');
    Route::post('/login',[UserAuthenticate::class,'handleLogin'])->name('user.handleLogin');
    Route::get('/register',[UserAuthenticate::class,'register'])->name('user.register');
    Route::post('/register',[UserAuthenticate::class,'handleRegister'])->name('user.handleRegister');
});

Route::middleware('auth')->prefix('user')->group(function(){
     Route::get('/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');
     Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
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
     });

     //Les routes de gestion des directeurs de l'hopital par l'hopital
     Route::prefix('director')->group(function(){
         Route::get('/create-director',[DirectorController::class, 'create'])->name('directeur.create');
        Route::post('/create-director',[DirectorController::class, 'store'])->name('directeur.store');
     });
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
        Route::get('/', [DeclarationNaissance::class, 'index'])->name('statement.index');
        Route::get('/birth/create', [DeclarationNaissance::class, 'create'])->name('statement.create');
        Route::post('/birth/create', [DeclarationNaissance::class, 'store'])->name('statement.store');
        Route::get('/birth/edit/{naisshop}', [DeclarationNaissance::class, 'edit'])->name('statement.edit');
        Route::put('/birth/edit/{naisshop}', [DeclarationNaissance::class, 'update'])->name('statement.update');
        Route::get('/birth/delete/{naisshop}', [DeclarationNaissance::class, 'delete'])->name('statement.delete');
        Route::get('/birth/download/{id}', [DeclarationNaissance::class, 'download'])->name('statement.download');
        Route::get('/birth/{id}', [DeclarationNaissance::class, 'show'])->name('statement.show');
        Route::get('/mairie/{id}', [DeclarationNaissance::class, 'mairieshow'])->name('naissHopmairie.show');
    });
});


//Les routes de gestions des directeurs 
Route::prefix('director')->group(function() {
    Route::get('/login', [AuthenticateDirector::class, 'login'])->name('directeur.login');
    Route::post('/login', [AuthenticateDirector::class, 'handleLogin'])->name('directeur.handleLogin');
});

Route::middleware('director')->prefix('director')->group(function(){
     Route::get('/dashboard',[DirectorDashboard::class,'dashboard'])->name('directeur.dashboard');
     Route::get('/logout', [DirectorDashboard::class, 'logout'])->name('directeur.logout');

     //Les routes de gestion des personnels par l'hopital 
});








//Les routes definition du accès 
Route::get('/validate-hopital-account/{email}', [AuthenticateHopial::class, 'defineAccess']);
Route::post('/validate-hopital-account/{email}', [AuthenticateHopial::class, 'submitDefineAccess'])->name('hopital.validate');
Route::get('/validate-account/{email}', [AuthenticateDoctor::class, 'defineAccess']);
Route::post('/validate-account/{email}', [AuthenticateDoctor::class, 'submitDefineAccess'])->name('doctor.validate');
Route::get('/validate-director-account/{email}', [AuthenticateDirector::class, 'defineAccess']);
Route::post('/validate-director-account/{email}', [AuthenticateDirector::class, 'submitDefineAccess'])->name('directeur.validate');
 

