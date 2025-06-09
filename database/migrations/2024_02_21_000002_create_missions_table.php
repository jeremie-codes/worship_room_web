<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('lieu');
            $table->text('objet');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('duree')->comment('Durée en jours');
            $table->decimal('frais_mission', 10, 2)->default(0);
            $table->enum('status', ['en_preparation', 'en_cours', 'terminee', 'annulee'])->default('en_preparation');
            $table->text('observations')->nullable();
            $table->text('rapport')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('missions');
    }
};
