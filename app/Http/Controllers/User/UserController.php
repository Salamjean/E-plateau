<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        return view('user.dashboard');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
