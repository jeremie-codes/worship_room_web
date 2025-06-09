<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grilles_salaire', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('echelon');
            $table->decimal('salaire_base', 12, 2);
            $table->decimal('indice', 8, 2)->nullable();
            $table->date('date_effet');
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->unique(['grade', 'echelon']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('grilles_salaire');
    }
};