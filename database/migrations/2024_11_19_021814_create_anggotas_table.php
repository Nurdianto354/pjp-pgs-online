<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_anggota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->unsignedBigInteger('kelas_id');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('m_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_anggota');
    }
}
