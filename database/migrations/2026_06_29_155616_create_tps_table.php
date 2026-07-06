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
        Schema::create('tps', function (Blueprint $table) {

            $table->id();

            $table->string('kode_tps',20)->unique();

            $table->string('nama_tps',100);

            $table->text('alamat');

            $table->decimal('latitude',10,7);

            $table->decimal('longitude',10,7);

            $table->integer('kapasitas')
                  ->comment('Kg');

            $table->enum('status',[
                'Aktif',
                'Tidak Aktif'
            ])->default('Aktif');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps');
    }
};