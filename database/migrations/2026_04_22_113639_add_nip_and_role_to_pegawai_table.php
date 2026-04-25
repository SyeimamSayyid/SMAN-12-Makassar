<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawai', 'nip')) {
                $table->string('nip')->nullable()->after('nama');
            }
        });
        
        // Ubah enum jabatan untuk menambah role baru
        DB::statement("ALTER TABLE pegawai MODIFY COLUMN jabatan ENUM(
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Guru',
            'Guru BK',
            'Kepala Perpustakaan',
            'Kepala Laboratorium',
            'Pembimbing Ekstrakurikuler',
            'Staff TU'
        ) DEFAULT 'Guru'");
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('pegawai', 'nip')) {
                $table->dropColumn('nip');
            }
        });
        
        // Kembalikan enum ke semula
        DB::statement("ALTER TABLE pegawai MODIFY COLUMN jabatan ENUM(
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Guru',
            'Staff TU'
        ) DEFAULT 'Guru'");
    }
};