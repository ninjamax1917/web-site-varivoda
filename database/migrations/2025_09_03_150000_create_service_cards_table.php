<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_cards', function (Blueprint $table) {
            $table->id();
            $table->string('page'); // slug страницы
            $table->string('title');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            $table->index(['page', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_cards');
    }
};
