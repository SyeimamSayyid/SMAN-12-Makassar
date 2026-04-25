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
        // Tabel Statistik Sekolah (Data Utama)
        Schema::create('statistik_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // kelas_10, kelas_11, kelas_12, total
            $table->integer('jumlah_siswa')->default(0);
            $table->integer('laki_laki')->default(0);
            $table->integer('perempuan')->default(0);
            $table->integer('jumlah_rombel')->default(0); // Rombongan Belajar
            $table->string('tahun_ajaran');
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Mutasi Siswa (Masuk/Keluar per Bulan)
        Schema::create('mutasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->enum('kelas', ['10', '11', '12']);
            $table->enum('jenis_mutasi', ['masuk', 'keluar']);
            $table->integer('jumlah')->default(0);
            $table->string('keterangan')->nullable();
            $table->date('tanggal');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabel Statistik Bulanan (Rekap per Bulan)
        Schema::create('statistik_bulanan', function (Blueprint $table) {
            $table->id();
            $table->enum('kelas', ['10', '11', '12']);
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('jumlah_awal')->default(0);
            $table->integer('masuk')->default(0);
            $table->integer('keluar')->default(0);
            $table->integer('jumlah_akhir')->default(0);
            $table->integer('laki_laki')->default(0);
            $table->integer('perempuan')->default(0);
            $table->timestamps();
            
            $table->unique(['kelas', 'bulan', 'tahun'], 'unique_statistik_bulanan');
        });

        // Tabel Prestasi (untuk statistik prestasi)
        Schema::create('statistik_prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prestasi');
            $table->enum('tingkat', ['Sekolah', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->enum('juara', ['1', '2', '3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Partisipasi']);
            $table->integer('tahun');
            $table->string('penyelenggara')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_siswa');
        Schema::dropIfExists('statistik_bulanan');
        Schema::dropIfExists('statistik_prestasi');
        Schema::dropIfExists('statistik_sekolah');
    }
};