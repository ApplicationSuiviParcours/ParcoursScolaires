<?php
// database/migrations/[timestamp]_add_classe_id_to_eleves_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClasseIdToElevesTable extends Migration
{
    public function up()
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->foreignId('classe_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropColumn('classe_id');
        });
    }
}