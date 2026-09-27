<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE jadwal
            MODIFY status ENUM(
                'tersedia',
                'booked',
                'maintenance',
                'libur'
            ) NOT NULL DEFAULT 'tersedia'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE jadwal
            MODIFY status ENUM(
                'tersedia',
                'booked',
                'maintenance'
            ) NOT NULL DEFAULT 'tersedia'
        ");
    }
};
