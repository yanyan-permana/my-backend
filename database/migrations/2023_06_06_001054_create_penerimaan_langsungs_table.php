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
        Schema::create('t_penerimaan_langsung', function (Blueprint $table) {
            $table->bigIncrements('tpl_id');
            $table->unsignedBigInteger('usr_id');
            $table->foreign('usr_id')->references('usr_id')->on('m_user');
            $table->string('trx_id');
            $table->string('trans_jns');
            $table->string('tpl_nomor');
            $table->string('tpl_tanggal');
            $table->double('tpl_nominal')->default(0.00);
            $table->text('tpl_keterangan')->nullable();
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
        Schema::dropIfExists('t_penerimaan_langsung');
    }
};
