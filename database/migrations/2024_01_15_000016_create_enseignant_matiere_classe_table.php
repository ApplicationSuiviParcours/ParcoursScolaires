<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseignant_matiere_classe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['enseignant_id', 'matiere_id', 'classe_id', 'annee_scolaire_id'], 'emca_unique_index'); // Voici le nom court (64 caractères max));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignant_matiere_classe');
    }
};
