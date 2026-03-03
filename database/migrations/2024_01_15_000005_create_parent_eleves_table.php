<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('genre', ['m', 'f']); // Changé en enum pour limiter les valeurs
            $table->string('profession')->nullable();
            $table->string('telephone');
            $table->string('email')->nullable()->unique(); // Ajout unique
            $table->string('adresse');
            $table->string('photo')->nullable(); // NOUVEAU
            $table->date('date_naissance')->nullable(); // NOUVEAU
            $table->string('lieu_naissance')->nullable(); // NOUVEAU
            $table->boolean('statut')->default(true); // NOUVEAU
            $table->text('notes')->nullable(); // NOUVEAU
            $table->timestamps();
            
            // Index pour la recherche
            $table->index(['nom', 'prenom']);
            $table->index('email');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_eleves');
    }
};