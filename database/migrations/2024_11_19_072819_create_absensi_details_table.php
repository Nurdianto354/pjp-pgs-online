<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('absensi_id');
            $table->unsignedBigInteger('anggota_id');
            $table->char('absensi', 1)->nullable();
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('m_kelas')->onDelete('cascade');
            $table->foreign('absensi_id')->references('id')->on('absensi')->onDelete('cascade');
            $table->foreign('anggota_id')->references('id')->on('m_anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_detail');
    }
}
