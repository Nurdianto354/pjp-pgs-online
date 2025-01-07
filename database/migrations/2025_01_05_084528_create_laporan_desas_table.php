<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanDesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bk_laporan_desa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('bulan');
            $table->bigInteger('tahun');
            $table->string('program');
            $table->tinyInteger('kategori');
            $table->tinyInteger('realisasi');
            $table->boolean('status');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bk_laporan_desa');
    }
}
