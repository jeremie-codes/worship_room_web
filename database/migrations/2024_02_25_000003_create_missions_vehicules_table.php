<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('missions_vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('chauffeur_id')->constrained();
            $table->foreignId('vehicule_id')->constrained();
            $table->text('motif');
            $table->text('itineraire');
            $table->datetime('date_heure_depart');
            $table->datetime('date_heure_retour')->nullable();
            $table->integer('kilometrage_depart');
            $table->integer('kilometrage_retour')->nullable();
            $table->enum('status', ['en_attente', 'approuve', 'en_cours', 'termine', 'annule'])->default('en_attente');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('missions_vehicules');
    }
};
