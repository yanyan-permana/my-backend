<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengajuan', function (Blueprint $table) {
            $table->id('aju_id');
            $table->unsignedBigInteger('kry_id');
            $table->foreign('kry_id')->references('kry_id')->on('m_karyawan');
            $table->unsignedBigInteger('trx_id');
            $table->foreign('trx_id')->references('trx_id')->on('m_jenis_transaksi');
            $table->string('aju_nomor');
            $table->string('aju_tanggal');
            $table->double('aju_nominal')->default(0.00);
            $table->text('aju_keterangan')->nullable();
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
        Schema::dropIfExists('t_pengajuan');
    }
};
