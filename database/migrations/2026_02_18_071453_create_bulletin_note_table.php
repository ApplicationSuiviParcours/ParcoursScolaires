<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletin_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulletin_id')->constrained()->onDelete('cascade');
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->decimal('coefficient', 5, 2)->default(1)->nullable();
            $table->string('appreciation')->nullable();
            $table->integer('rang')->nullable();
            $table->timestamps();
            
            // Éviter les doublons
            $table->unique(['bulletin_id', 'note_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletin_note');
    }
};