<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengangkutans', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('optimasi_rute_id')
                ->constrained('optimasi_rutes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Waktu
            $table->date('tanggal');
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();

            // Status Pengangkutan
            $table->enum('status', [
                'Belum Berangkat',
                'Sedang Berjalan',
                'Selesai',
            ])->default('Belum Berangkat');

            // Status Perjalanan
            $table->enum('status_perjalanan', [
                'Menuju TPS',
                'Menuju TPA',
                'Selesai',
            ])->default('Menuju TPS');

            // Muatan Kendaraan
            $table->decimal('kapasitas_kendaraan', 10, 2);
            $table->decimal('muatan_sekarang', 10, 2)->default(0);

            // Catatan
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Satu Driver Satu Pengangkutan / Hari
            $table->unique(['driver_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengangkutans');
    }
};