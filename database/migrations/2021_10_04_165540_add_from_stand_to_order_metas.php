<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromStandToOrderMetas extends Migration
{
    public function up()
    {
        Schema::table('order_metas', function (Blueprint $table) {
            $table->boolean('from_stand')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_metas', function (Blueprint $table) {
            $table->dropColumn('from_stand');
        });
    }
}
