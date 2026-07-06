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
        Schema::create('drivers', function (Blueprint $table) {

            $table->id();

            $table->string('kode_driver', 20)->unique();

            $table->string('nama', 100);

            $table->string('nik', 20)->unique();

            $table->string('no_hp', 20);

            $table->text('alamat')->nullable();

            $table->enum('jenis_kelamin', [
                'L',
                'P'
            ]);

            $table->enum('status', [
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
        Schema::dropIfExists('drivers');
    }
};