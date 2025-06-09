<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->enum('type', ['entrant', 'sortant', 'interne']);
            $table->enum('motif', [
                'demande',
                'reponse',
                'notification',
                'convocation',
                'rapport',
                'facture',
                'contrat',
                'correspondance',
                'autre'
            ]);
            $table->string('objet');
            $table->text('description')->nullable();

            // Expéditeur/Destinataire
            $table->string('expediteur')->nullable();
            $table->string('destinataire')->nullable();
            $table->foreignId('service_expediteur_id')->nullable()->constrained('services');
            $table->foreignId('service_destinataire_id')->nullable()->constrained('services');

            // Dates importantes
            $table->date('date_courrier');
            $table->date('date_reception')->nullable();
            $table->date('date_envoi')->nullable();
            $table->date('date_limite_reponse')->nullable();

            // Priorité et statut
            $table->enum('priorite', ['normale', 'urgente', 'tres_urgente'])->default('normale');
            $table->enum('status', [
                'en_attente',
                'en_cours_traitement',
                'traite',
                'archive',
                'en_attente_reponse',
                'clos'
            ])->default('en_attente');

            // Traçabilité
            $table->foreignId('user_id')->constrained()->comment('Enregistreur');
            $table->foreignId('agent_responsable_id')->nullable()->references('id')->on('users');

            // Classification
            $table->string('repertoire')->nullable()->comment('Classement/Dossier');
            $table->string('numero_chrono')->nullable();
            $table->boolean('confidentiel')->default(false);

            // Suivi
            $table->text('observations')->nullable();
            $table->json('historique_traitement')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers');
    }
};
