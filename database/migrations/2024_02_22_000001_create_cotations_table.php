<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->year('annee');
            $table->integer('note_competence')->comment('Note sur 20');
            $table->integer('note_performance')->comment('Note sur 20');
            $table->integer('note_comportement')->comment('Note sur 20');
            $table->integer('note_finale')->comment('Moyenne des 3 notes');
            $table->text('observations')->nullable();
            $table->enum('status', ['en_cours', 'valide', 'refuse'])->default('en_cours');
            $table->text('commentaire_validateur')->nullable();
            $table->timestamps();

            // Un user ne peut avoir qu'une seule cotation par année
            $table->unique(['user_id', 'annee']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotations');
    }
};
