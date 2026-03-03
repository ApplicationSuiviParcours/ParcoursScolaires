<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique(); // Numéro unique de l'élève
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('genre'); // M ou F
            $table->string('adresse');
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable();
            $table->date('date_inscription');
            $table->boolean('statut')->default(true); // true = actif, false = inactif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
