<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents_courriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->string('nom_document');
            $table->string('nom_fichier');
            $table->string('chemin_fichier');
            $table->string('type_mime');
            $table->bigInteger('taille_fichier');
            $table->enum('type_document', [
                'courrier_principal',
                'piece_jointe',
                'reponse',
                'accusé_reception',
                'autre'
            ])->default('courrier_principal');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_courriers');
    }
};