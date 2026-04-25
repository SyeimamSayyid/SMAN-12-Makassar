<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            // Ubah kolom video dari string menjadi JSON
            $table->json('video')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->string('video')->nullable()->change();
        });
    }
};