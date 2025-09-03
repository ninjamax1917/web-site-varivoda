<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_card_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_card_id')->constrained('service_cards')->cascadeOnDelete();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            $table->index(['service_card_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_card_images');
    }
};
