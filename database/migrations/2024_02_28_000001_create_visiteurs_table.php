<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visiteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->enum('type', ['entrepreneur', 'visiteur']);
            $table->string('entreprise')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('piece_identite')->nullable();
            $table->string('numero_piece')->nullable();
            $table->text('motif');
            $table->foreignId('service_id')->nullable()->constrained()->comment('Direction/Service de destination');
            $table->string('destination')->nullable()->comment('Personne ou bureau spécifique');
            $table->datetime('heure_arrivee');
            $table->datetime('heure_depart')->nullable();
            $table->text('observations')->nullable();
            $table->enum('status', ['en_visite', 'parti', 'refuse'])->default('en_visite');
            $table->foreignId('user_id')->constrained()->comment('Agent d\'accueil qui a enregistré');
            $table->string('badge_numero')->nullable()->comment('Numéro du badge visiteur');
            $table->boolean('vehicule')->default(false);
            $table->string('immatriculation_vehicule')->nullable();
            $table->json('accompagnants')->nullable()->comment('Liste des accompagnants');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visiteurs');
    }
};