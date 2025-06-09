<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('reference')->unique();
            $table->year('annee');
            $table->integer('mois')->comment('1-12');
            $table->decimal('salaire_base', 12, 2);
            $table->decimal('primes', 12, 2)->default(0);
            $table->decimal('heures_supplementaires', 12, 2)->default(0);
            $table->decimal('indemnites', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('retenues_fiscales', 12, 2)->default(0);
            $table->decimal('cotisations_sociales', 12, 2)->default(0);
            $table->decimal('avances', 12, 2)->default(0);
            $table->decimal('net_a_payer', 12, 2);
            $table->enum('status', ['en_preparation', 'valide', 'paye', 'annule'])->default('en_preparation');
            $table->date('date_paiement')->nullable();
            $table->string('mode_paiement')->nullable()->comment('virement, especes, cheque');
            $table->text('observations')->nullable();
            $table->timestamps();

            // Un user ne peut avoir qu'un seul paiement par mois
            $table->unique(['user_id', 'annee', 'mois']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
