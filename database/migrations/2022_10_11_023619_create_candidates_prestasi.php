<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates_prestasi', function (Blueprint $table) {
            $table->year('tahun_periode');
            $table->id('no_daftar');
            $table->string('nama');
            $table->integer('id_pilihan1')->nullable();
            $table->integer('id_pilihan2')->nullable();
            $table->integer('id_pilihan3')->nullable();
            $table->integer('kode_kelompok_bidang')->nullable();
            $table->string('alamat')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('telp')->nullable();
            $table->year('tahun_periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates_prestasi');
    }
};
