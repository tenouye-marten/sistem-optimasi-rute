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
        Schema::create('optimasi_rute_details', function (Blueprint $table) {

            $table->id();

            // Relasi Header Optimasi
            $table->foreignId('optimasi_rute_id')
                ->constrained('optimasi_rutes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // TPS
            $table->foreignId('tps_id')
                ->constrained('tps')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Urutan Nearest Neighbor
            $table->unsignedInteger('urutan');

            // Jarak dari titik sebelumnya
            $table->decimal('jarak',10,2)->default(0);

            // Estimasi ke TPS tersebut
            $table->unsignedInteger('estimasi_waktu')->default(0);

            $table->timestamps();

            // Satu TPS hanya satu kali dalam satu optimasi
            $table->unique([
                'optimasi_rute_id',
                'tps_id'
            ]);

            // Urutan tidak boleh sama
            $table->unique([
                'optimasi_rute_id',
                'urutan'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('optimasi_rute_details');
    }
};