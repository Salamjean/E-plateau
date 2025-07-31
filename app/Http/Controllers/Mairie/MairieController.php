<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MairieController extends Controller
{
    public function dashboard(){
        return view('mairie.dashboard');
    }
}
