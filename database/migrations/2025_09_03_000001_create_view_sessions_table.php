<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('view_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('camera_id')->constrained('cameras')->cascadeOnDelete();
            $table->string('protocol', 16); // hls, webrtc, rtsp
            $table->timestamp('started_at');
            $table->timestamp('last_seen_at')->index();
            $table->string('ip', 64)->nullable();
            $table->string('ua', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('view_sessions');
    }
};
