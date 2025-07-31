<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_naissance_id')->constrained()->onDelete('cascade'); // Clé étrangère vers naiss_hops
            $table->date('date_naissance'); // Date de naissance de l'enfant (lowercase now!)
            $table->string('sexe'); // Sexe de l'enfant
            $table->string('nombreEnf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfants');
    }
};
