<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQueueIdToCertificates extends Migration
{
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->unsignedBigInteger('queue_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('queue_id');
        });
    }
}
