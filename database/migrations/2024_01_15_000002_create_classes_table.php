<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // ex: 6ème A, Terminale S1
            $table->string('niveau'); // ex: 6ème, 5ème, Terminale
            $table->string('serie')->nullable(); // ex: S1, S2, L1, L2, ES
            $table->integer('capacite'); // nombre d'élèves maximum
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
