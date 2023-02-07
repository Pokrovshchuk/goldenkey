<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('hall_id');
            $table->nullableTimestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
}
