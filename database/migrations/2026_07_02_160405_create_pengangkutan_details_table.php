<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengangkutan_details', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('pengangkutan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('optimasi_rute_detail_id')->constrained('optimasi_rute_details')->cascadeOnDelete();
            $table->foreignId('tps_id')->constrained('tps')->cascadeOnUpdate()->restrictOnDelete();

            // Urutan Rute
            $table->unsignedInteger('urutan');

            // Volume Sampah
            $table->decimal('volume_total', 10, 2)->default(0);
            $table->decimal('volume_diangkut', 10, 2)->default(0);
            $table->decimal('volume_sisa', 10, 2)->default(0);

            // Waktu
            $table->timestamp('waktu_tiba')->nullable();
            $table->timestamp('waktu_selesai')->nullable();

            // Status TPS
            $table->enum('status', ['Belum', 'Proses', 'Selesai'])->default('Belum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengangkutan_details');
    }
};