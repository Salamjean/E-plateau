<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Caisse;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AgentAdminController extends Controller
{
    public function agent() {
        $agents = Agent::all();
        return view('admin.personnel.agent', compact('agents'));
    }

    public function personal() {
        $doctors = Doctor::all();
        return view('admin.personnel.personal', compact('doctors'));
    }

    public function caisse(){
        $caisses = Caisse::all();
        return view('admin.personnel.caisse', compact('caisses'));
     }
     
}
