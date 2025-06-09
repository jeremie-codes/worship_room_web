<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suivi_courriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->enum('action', [
                'creation',
                'reception',
                'transmission',
                'traitement',
                'reponse',
                'archivage',
                'modification',
                'cloture'
            ]);
            $table->text('commentaire')->nullable();
            $table->json('donnees_avant')->nullable();
            $table->json('donnees_apres')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suivi_courriers');
    }
};