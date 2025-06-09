<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('elements_salaire', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('code')->unique();
            $table->enum('type', ['prime', 'indemnite', 'deduction', 'cotisation']);
            $table->enum('mode_calcul', ['fixe', 'pourcentage', 'variable']);
            $table->decimal('valeur', 12, 2)->nullable()->comment('Montant fixe ou pourcentage');
            $table->boolean('obligatoire')->default(false);
            $table->boolean('imposable')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elements_salaire');
    }
};