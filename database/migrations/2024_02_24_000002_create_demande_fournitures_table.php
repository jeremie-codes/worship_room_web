<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demande_fournitures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('article_id')->constrained();
            $table->integer('quantite');
            $table->enum('niveau_urgence', ['normal', 'urgent', 'tres_urgent']);
            $table->text('motif');
            $table->enum('status', ['en_attente', 'approuve', 'refuse', 'livre'])->default('en_attente');
            $table->text('commentaire_validateur')->nullable();
            $table->timestamp('date_livraison')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demande_fournitures');
    }
};
