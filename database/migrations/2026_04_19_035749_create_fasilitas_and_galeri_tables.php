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
        // ========== TABEL FASILITAS ==========
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ikon')->nullable();
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('info_tambahan')->nullable();
            $table->integer('jumlah')->default(1);
            $table->enum('kategori', ['ruang_kelas', 'laboratorium', 'perpustakaan', 'olahraga', 'aula', 'kantin', 'lainnya'])->default('lainnya');
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // ========== TABEL GALERI ==========
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->json('gambar_lain')->nullable();
            $table->enum('kategori', ['Upacara', 'Akademik', 'Olahraga', 'Seni', 'Keagamaan', 'Lomba', 'Study Tour', 'Lainnya'])->default('Lainnya');
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('lokasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // ========== TABEL KATEGORI GALERI (Opsional) ==========
        Schema::create('kategori_galeri', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('warna')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_galeri');
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('fasilitas');
    }
};