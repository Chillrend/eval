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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('id_prodi');
            $table->string('jurusan');
            $table->integer('id_politeknik');
            $table->string('politeknik');
            $table->integer('id_kelompok_bidang');
            $table->string('kelompok_bidang');
            $table->integer('quota')->nullable();
            $table->integer('tertampung')->nullable();
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
        Schema::dropIfExists('kode_prodi');
    }
};
