<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rtsp_url');
            $table->string('preview')->nullable();
            $table->unsignedBigInteger('views_today')->default(0);
            $table->unsignedBigInteger('views_online')->default(0);
            $table->unsignedBigInteger('views_total')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('cameras');
    }
};
