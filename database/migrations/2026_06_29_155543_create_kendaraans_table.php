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
        Schema::create('kendaraans', function (Blueprint $table) {

            $table->id();

            $table->string('kode_kendaraan',20)->unique();

            $table->string('nama_kendaraan',100);

            $table->string('nomor_polisi',20)->unique();

            $table->integer('kapasitas')
                  ->comment('Kapasitas kendaraan dalam Kg');

            $table->enum('status',[
                'Aktif',
                'Tidak Aktif',
                'Perawatan'
            ])->default('Aktif');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};