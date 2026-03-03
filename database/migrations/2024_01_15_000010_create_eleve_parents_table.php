<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleve_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->foreignId('parent_eleve_id')->constrained('parent_eleves')->onDelete('cascade');
            $table->string('lien_parental'); // père, mère, tuteur, etc.
            $table->timestamps();
            $table->unique(['eleve_id', 'parent_eleve_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleve_parents');
    }
};
