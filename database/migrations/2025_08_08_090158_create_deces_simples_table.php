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
        Schema::create('deces_simples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('numberR');
            $table->string('dateR');
            $table->string('pActe')->nullable();
            $table->string('CNIdfnt')->nullable();
            $table->string('CNIdcl')->nullable();
            $table->string('documentMariage')->nullable();
            $table->string('RequisPolice')->nullable();
            $table->string('CMU')->nullable();
            $table->string('reference');
            $table->string('commune')->nullable();
            $table->string('etat')->default('en attente'); // État par défaut
            $table->string('statut_livraison')->nullable(); // État par défaut
            $table->boolean('is_read')->default(false); // Statut de lecture
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ajout de user_id
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null'); // Ajout de agent_id
            $table->foreignId('livraison_id')->nullable()->constrained('livraisons')->onDelete('set null'); // Ajout de livraison
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
        Schema::dropIfExists('deces_simples');
    }
};
