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
        Schema::create('optimasi_rutes', function (Blueprint $table) {

            $table->id();

            // Kode Optimasi
            $table->string('kode_optimasi',20)->unique();

            // Tanggal Generate
            $table->date('tanggal_generate');

            // Driver
            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Kendaraan Driver
            $table->foreignId('kendaraan_id')
                ->constrained('kendaraans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Pool Awal
            $table->foreignId('pool_id')
                ->constrained('pools')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // TPA Tujuan
            $table->foreignId('tpa_id')
                ->constrained('tpas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Hasil Optimasi
            $table->unsignedInteger('jumlah_tps')->default(0);

            $table->decimal('total_jarak',10,2)->default(0);

            $table->unsignedInteger('estimasi_waktu')->default(0);

            $table->enum('status',[
                'Aktif',
                'Tidak Aktif'
            ])->default('Aktif');

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('optimasi_rutes');
    }
};