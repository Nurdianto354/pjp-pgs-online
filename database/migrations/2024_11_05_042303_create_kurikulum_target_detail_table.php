<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurikulumTargetDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurikulum_target_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kurikulum_target_id');
            $table->unsignedBigInteger('karakter_id');
            $table->unsignedBigInteger('materi_id');
            $table->string('target')->nullable();
            $table->unsignedBigInteger('satuan_id');
            $table->timestamps();

            $table->foreign('kurikulum_target_id')->references('id')->on('kurikulum_target')->onDelete('cascade');
            $table->foreign('karakter_id')->references('id')->on('m_karakter')->onDelete('cascade');
            $table->foreign('materi_id')->references('id')->on('m_materi')->onDelete('cascade');
            $table->foreign('satuan_id')->references('id')->on('m_satuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kurikulum_target_detail');
    }
}
