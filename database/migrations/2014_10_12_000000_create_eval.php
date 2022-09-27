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
        Schema::create('eval', function (Blueprint $table) {
            $table->id('no_daftar');
            $table->string('nama');
            $table->integer('id_pilihan1');
            $table->integer('id_pilihan2');
            $table->integer('id_pilihan3');
            $table->integer('kode_kelompok_bidang');
            $table->string('alamat');
            $table->string('sekolah');
            $table->integer('telp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eval');
    }
};
