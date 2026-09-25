<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_pelanggan')
                ->constrained('pelanggan')
                ->onDelete('cascade');

            $table->foreignId('id_jadwal')
                ->constrained('jadwal')
                ->onDelete('cascade');

            $table->string('nama_tim');

            // Total harga sesuai durasi booking
            $table->decimal('total_harga', 12, 2);

            $table->enum('status', [
                'menunggu',
                'dikonfirmasi',
                'ditolak',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
