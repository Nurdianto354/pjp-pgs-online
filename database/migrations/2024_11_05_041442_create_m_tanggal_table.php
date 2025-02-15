<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMTanggalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_tanggal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tanggal');
            $table->tinyInteger('hari');
            $table->tinyInteger('bulan');
            $table->bigInteger('tahun');
            $table->boolean('status');
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
        Schema::dropIfExists('m_tanggal');
    }
}
