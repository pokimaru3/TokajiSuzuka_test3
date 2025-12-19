<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToShopsTable extends Migration
{
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('email')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
