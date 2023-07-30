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
        Schema::create('t_pertanggung_jawaban', function (Blueprint $table) {
            $table->bigIncrements('tgjwb_id');
            $table->integer('real_id');
            $table->string('trans_jns');
            $table->string('tgjwb_nomor');
            $table->string('tgjwb_tanggal');
            $table->double('tgjwb_nominal')->default(0.00);
            $table->text('tgjwb_keterangan')->nullable();
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
        Schema::dropIfExists('t_pertanggung_jawaban');
    }
};
