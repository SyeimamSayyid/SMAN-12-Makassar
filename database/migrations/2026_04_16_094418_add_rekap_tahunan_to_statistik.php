<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Rekap Tahunan
        Schema::create('rekap_tahunan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_ajaran_awal');
            $table->year('tahun_ajaran_akhir');
            $table->string('semester')->default('Ganjil');
            
            // Data Awal Tahun
            $table->integer('jumlah_awal_kelas10')->default(0);
            $table->integer('jumlah_awal_kelas11')->default(0);
            $table->integer('jumlah_awal_kelas12')->default(0);
            $table->integer('total_awal')->default(0);
            
            // Mutasi Masuk per Kelas
            $table->integer('masuk_kelas10')->default(0);
            $table->integer('masuk_kelas11')->default(0);
            $table->integer('masuk_kelas12')->default(0);
            $table->integer('total_masuk')->default(0);
            
            // Mutasi Keluar per Kelas
            $table->integer('keluar_kelas10')->default(0);
            $table->integer('keluar_kelas11')->default(0);
            $table->integer('keluar_kelas12')->default(0);
            $table->integer('total_keluar')->default(0);
            
            // Kelulusan
            $table->integer('lulus_kelas12')->default(0);
            $table->float('persentase_kelulusan')->default(0);
            
            // Data Akhir Tahun
            $table->integer('jumlah_akhir_kelas10')->default(0);
            $table->integer('jumlah_akhir_kelas11')->default(0);
            $table->integer('jumlah_akhir_kelas12')->default(0);
            $table->integer('total_akhir')->default(0);
            
            // Gender
            $table->integer('total_laki')->default(0);
            $table->integer('total_perempuan')->default(0);
            
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->unique(['tahun_ajaran_awal', 'tahun_ajaran_akhir', 'semester'], 'unique_rekap_tahunan');
        });

        // Tabel Detail Kelulusan per Kelas
        Schema::create('detail_kelulusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekap_tahunan_id')->constrained('rekap_tahunan')->onDelete('cascade');
            $table->string('kelas')->comment('12 IPA 1, 12 IPS 2, dll');
            $table->integer('jumlah_siswa')->default(0);
            $table->integer('lulus')->default(0);
            $table->integer('tidak_lulus')->default(0);
            $table->float('persentase')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_kelulusan');
        Schema::dropIfExists('rekap_tahunan');
    }
};