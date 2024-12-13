<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariLibursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_hari_libur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('divisi_id');
            $table->bigInteger('tanggal');
            $table->tinyInteger('hari');
            $table->tinyInteger('bulan');
            $table->tinyInteger('tahun');
            $table->string('keterangan')->nullable();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('divisi_id')->references('id')->on('m_divisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivitas_hari_libur');
    }
}
