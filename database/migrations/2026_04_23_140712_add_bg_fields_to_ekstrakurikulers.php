<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->string('bg_type', 20)->nullable()->after('background');
            $table->string('bg_color1', 7)->nullable()->after('bg_type');
            $table->string('bg_color2', 7)->nullable()->after('bg_color1');
            $table->string('bg_direction', 20)->nullable()->after('bg_color2');
            $table->integer('bg_opacity')->nullable()->default(50)->after('bg_direction');
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->dropColumn(['bg_type', 'bg_color1', 'bg_color2', 'bg_direction', 'bg_opacity']);
        });
    }
};