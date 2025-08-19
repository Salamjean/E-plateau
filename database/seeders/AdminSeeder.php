<?php

namespace Database\Seeders;

use App\Models\Mairie;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Mairie::create([
            'name' => 'plateau',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('azertyui'),
        ]);
       
    }
}
