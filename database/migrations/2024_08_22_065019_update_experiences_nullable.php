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
        Schema::table('experiences', function (Blueprint $table) {
            $table->string('judul', length: 150)->nullable();
            $table->string('subjudul', length: 150)->nullable();
            $table->string('deskripsi', length: 500)->nullable();
            $table->string('tgl_experience', length: 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropIfExists('experiences');
        });
    }
};
