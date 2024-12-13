<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_jadwal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('divisi_id');
            $table->tinyInteger('hari')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
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
        Schema::dropIfExists('aktivitas_jadwal');
    }
}
