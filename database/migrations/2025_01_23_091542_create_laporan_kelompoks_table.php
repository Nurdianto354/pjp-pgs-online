<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKelompoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bk_laporan_kelompok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('bulan');
            $table->bigInteger('tahun');
            $table->unsignedBigInteger('divisi_id');
            $table->unsignedBigInteger('kelas_id');
            $table->text('kasus');
            $table->bigInteger('tanggal');
            $table->boolean('status');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');

            $table->foreign('divisi_id')->references('id')->on('m_divisi')->onDelete('cascade');
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
        Schema::dropIfExists('bk_laporan_kelompok');
    }
}
