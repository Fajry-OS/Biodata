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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_profile')->nullable;
            $table->string('judul', length: 150)->nullalable();
            $table->string('subjudul', length: 150)->nullalable();
            $table->string('deskripsi', length: 500)->nullalable();
            $table->string('tgl_experience', length: 150)->nullalable();
            $table->timestamps();

            $table->foreign('id_profile')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
