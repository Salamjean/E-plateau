<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAuthenticate extends Controller
{
    public function login(){
        return view('user.auth.login');
    }

    public function handleLogin(UserLoginRequest $request): RedirectResponse
    {
        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('user.login')->withErrors([
                'email' => 'Le mot de passe incorrect.',
            ]);
        }

        // Si l'authentification réussit, régénérer la session
        $request->session()->regenerate();

        // Rediriger vers la page de tableau de bord avec un message de succès
        return redirect()->intended(route('user.dashboard', absolute: false))->with('success', 'Bienvenue sur votre page!');
    }

    
    public function register(){
        return view('user.auth.register');
    }

    public function handleRegister(UserRegisterRequest $request): RedirectResponse
    {
        try {
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                Log::info('Profile picture stored at: ' . $profilePicturePath);
            }
            
            $users = new User();
            $users->name = $request->name;
            $users->prenom = $request->prenom;
            $users->email = $request->email;
            $users->commune = 'Plateau';
            $users->indicatif = '+225';
            $users->contact = $request->contact;
            $users->CMU = $request->CMU;
            $users->password = Hash::make($request->password);
            $users->profile_picture = $profilePicturePath;
            $users->save();

            return redirect()->route('user.login')->with('success', 'Votre compte a été créé avec succès. Vous pouvez vous connecter.');

        } catch (\Exception $e) {
            Log::error('Error during registration: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.'])->withInput();
        }
    }
}
