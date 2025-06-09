<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->comment('Utilisateur ayant créé la demande');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('duree')->comment('Durée en jours');
            $table->text('motif');
            $table->enum('status', ['en_attente', 'approuve_directeur', 'traite_rh', 'valide_drh', 'refuse'])->default('en_attente');
            $table->text('commentaire_directeur')->nullable();
            $table->text('commentaire_rh')->nullable();
            $table->text('commentaire_drh')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conges');
    }
};
