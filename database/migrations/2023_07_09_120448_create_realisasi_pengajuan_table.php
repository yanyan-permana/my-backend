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
        Schema::create('t_realisasi_pengajuan', function (Blueprint $table) {
            $table->id('real_id');
            $table->integer("aju_app_id");
            $table->string("real_nomor");
            $table->string("real_tanggal");
            $table->double("real_nominal")->default(0.00);
            $table->text("real_keterangan")->nullable();
            $table->integer("real_pjbt_id");
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
        Schema::dropIfExists('t_realisasi_pengajuan');
    }
};
