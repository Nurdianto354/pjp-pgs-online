<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('murid_id');
            $table->bigInteger('tanggal');
            $table->char('kehadiran', 1)->nullable();
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('m_kelas')->onDelete('cascade');
            $table->foreign('murid_id')->references('id')->on('murid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
