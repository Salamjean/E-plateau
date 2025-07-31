<?php

namespace Database\Seeders;

use App\Models\Mairie;
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
            'name' => 'Mairie - Plateau',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('azertyui'),
        ]);
    }
}
