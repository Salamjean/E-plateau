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
        Schema::create('mariages', function (Blueprint $table) {
            $table->id();
            $table->string('nomEpoux')->nullable();
            $table->string('prenomEpoux')->nullable();
            $table->string('dateNaissanceEpoux')->nullable();
            $table->string('lieuNaissanceEpoux')->nullable();
            $table->string('pieceIdentite');
            $table->string('extraitMariage');
            $table->string('CMU')->nullable();
            $table->string('reference');
            $table->string('commune')->nullable();
            $table->string('etat')->default('en attente');
            $table->string('statut_livraison')->nullable(); // État par défaut
            $table->boolean('is_read')->default(false); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null'); 
            $table->foreignId('livraison_id')->nullable()->constrained('livraisons')->onDelete('set null'); 
            $table->foreignId('livreur_id')->nullable()->constrained('livreurs')->onDelete('set null'); // Ajout de livreur

            //informations de livraison 
            $table->string('montant_timbre')->nullable();
            $table->string('montant_livraison')->nullable();
            $table->string('nom_destinataire')->nullable();
            $table->string('prenom_destinataire')->nullable();
            $table->string('email_destinataire')->nullable();
            $table->string('contact_destinataire')->nullable();
            $table->string('adresse_livraison')->nullable();
            $table->string('choix_option');
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('commune_livraison')->nullable();
            $table->string('quartier')->nullable();
            $table->string('livraison_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mariages');
    }
};
