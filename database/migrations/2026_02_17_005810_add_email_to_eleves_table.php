<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_email_to_eleves_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToElevesTable extends Migration
{
    public function up()
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('telephone');
        });
    }

    public function down()
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}