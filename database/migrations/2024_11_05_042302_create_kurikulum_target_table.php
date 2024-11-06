<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurikulumTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurikulum_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->timestamps();


            $table->foreign('kelas_id')->references('id')->on('m_kelas')->onDelete('cascade');
            $table->foreign('tahun_ajaran_id')->references('id')->on('m_tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kurikulum_target');
    }
}
