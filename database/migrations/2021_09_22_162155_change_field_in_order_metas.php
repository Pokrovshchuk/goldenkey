<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldInOrderMetas extends Migration
{
    public function up()
    {
        Schema::table('order_metas', function (Blueprint $table) {
            $table->boolean('more_than_one')->default(false)->change();
            $table->boolean('named')->default(false)->change();
            $table->string('name')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('order_metas', function (Blueprint $table) {
            //
        });
    }
}
