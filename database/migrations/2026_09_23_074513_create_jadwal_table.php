<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('harga', 12, 2)->default(0);

            $table->enum('status', [
                'tersedia',
                'booked',
                'maintenance'
            ])->default('tersedia');

            $table->timestamps();

            $table->unique([
                'tanggal',
                'jam_mulai',
                'jam_selesai'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
