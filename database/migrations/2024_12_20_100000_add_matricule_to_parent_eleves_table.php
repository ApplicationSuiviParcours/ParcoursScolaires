<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parent_eleves', function (Blueprint $table) {
            $table->string('matricule')
                  ->unique()
                  ->nullable()
                  ->after('user_id')
                  ->comment('Numéro matricule unique du parent (auto-généré)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parent_eleves', function (Blueprint $table) {
            $table->dropUnique(['matricule']);
            $table->dropColumn('matricule');
        });
    }
};
