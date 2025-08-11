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
        Schema::create('declaration_deces', function (Blueprint $table) {
            $table->id();
            $table->string('NomM');
            $table->string('PrM');
            $table->string('DateNaissance');
            $table->string('DateDeces');
            $table->string('Remarques');
            $table->string('nomHop');
            $table->string('choix');
            $table->string('commune');
            $table->string('codeDM')->default('rien')->unique();
            $table->string('codeCMD')->default('rien')->unique();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_deces');
    }
};
