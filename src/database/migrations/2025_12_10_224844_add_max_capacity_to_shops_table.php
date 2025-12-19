<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxCapacityToShopsTable extends Migration
{
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->integer('max_capacity')->default(50);
        });
    }

    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('max_capacity');
        });
    }
}
