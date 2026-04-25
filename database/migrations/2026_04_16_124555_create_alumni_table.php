<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Universitas (dikelola admin)
        Schema::create('universitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo')->nullable();
            $table->string('akronim')->nullable();
            $table->string('provinsi')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['Negeri', 'Swasta', 'Kedinasan'])->default('Negeri');
            $table->timestamps();
        });

        // Tabel Alumni
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            
            // Data sederhana dari user
            $table->string('nama_lengkap');
            $table->year('tahun_lulus');
            
            // Relasi ke universitas (diisi admin)
            $table->foreignId('universitas_id')->nullable()->constrained('universitas')->onDelete('set null');
            $table->string('program_studi')->nullable();
            $table->year('tahun_masuk_kuliah')->nullable();
            
            // Data tambahan (diisi admin)
            $table->string('pekerjaan')->nullable();
            $table->string('perusahaan')->nullable();
            $table->text('testimoni')->nullable();
            
            // Data lokasi (diisi admin)
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Kontak (diisi admin)
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            
            // Status Verifikasi
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            
            // Tampilkan di homepage
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
        Schema::dropIfExists('universitas');
    }
};