<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_booking')
                ->constrained('booking')
                ->cascadeOnDelete();

            $table->foreignId('id_jadwal')
                ->constrained('jadwal')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['id_booking', 'id_jadwal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_detail');
    }
};
