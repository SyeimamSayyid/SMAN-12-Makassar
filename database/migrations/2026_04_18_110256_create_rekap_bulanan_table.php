<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_bulanan', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            
            // Data per kelas - Kelas 10
            $table->integer('kelas10_awal')->default(0);
            $table->integer('kelas10_masuk')->default(0);
            $table->integer('kelas10_keluar')->default(0);
            $table->integer('kelas10_akhir')->default(0);
            $table->integer('kelas10_laki')->default(0);
            $table->integer('kelas10_perempuan')->default(0);
            
            // Data per kelas - Kelas 11
            $table->integer('kelas11_awal')->default(0);
            $table->integer('kelas11_masuk')->default(0);
            $table->integer('kelas11_keluar')->default(0);
            $table->integer('kelas11_akhir')->default(0);
            $table->integer('kelas11_laki')->default(0);
            $table->integer('kelas11_perempuan')->default(0);
            
            // Data per kelas - Kelas 12
            $table->integer('kelas12_awal')->default(0);
            $table->integer('kelas12_masuk')->default(0);
            $table->integer('kelas12_keluar')->default(0);
            $table->integer('kelas12_akhir')->default(0);
            $table->integer('kelas12_laki')->default(0);
            $table->integer('kelas12_perempuan')->default(0);
            
            // Total
            $table->integer('total_awal')->default(0);
            $table->integer('total_masuk')->default(0);
            $table->integer('total_keluar')->default(0);
            $table->integer('total_akhir')->default(0);
            $table->integer('total_laki')->default(0);
            $table->integer('total_perempuan')->default(0);
            
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Unique constraint: tidak boleh ada rekap dengan bulan, tahun, semester yang sama
            $table->unique(['bulan', 'tahun', 'semester'], 'unique_rekap_bulanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_bulanan');
    }
};