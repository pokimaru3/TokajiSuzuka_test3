<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('area');
            $table->string('genre');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
