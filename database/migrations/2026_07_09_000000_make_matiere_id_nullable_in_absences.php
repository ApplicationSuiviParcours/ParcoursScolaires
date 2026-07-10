<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            // Make column nullable to allow absences without a subject (primary).
            $table->foreignId('matiere_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->foreignId('matiere_id')->nullable(false)->change();
        });
    }
};