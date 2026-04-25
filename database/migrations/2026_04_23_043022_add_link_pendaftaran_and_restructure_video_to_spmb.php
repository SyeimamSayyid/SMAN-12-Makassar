<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            // Tambah link pendaftaran
            $table->string('link_pendaftaran')->nullable()->after('deskripsi');
            
            // Drop kolom video lama (string/json)
            $table->dropColumn('video');
        });
        
        // Tambah kolom video baru dengan struktur JSON yang lebih kompleks
        Schema::table('spmb', function (Blueprint $table) {
            $table->json('video')->nullable()->after('link_pendaftaran');
        });
    }

    public function down(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->dropColumn('link_pendaftaran');
            $table->dropColumn('video');
        });
        
        Schema::table('spmb', function (Blueprint $table) {
            $table->json('video')->nullable();
        });
    }
};