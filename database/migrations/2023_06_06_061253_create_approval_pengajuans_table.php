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
        Schema::create('t_approval_pengajuan', function (Blueprint $table) {
            $table->bigIncrements('aju_app_id');
            $table->integer('aju_id');
            $table->integer('aju_app_ver_jbt_id')->nullable();
            $table->string('aju_app_ver_tanggal')->nullable();
            $table->string('aju_app_ver_status')->nullable();
            $table->text('aju_app_ver_keterangan')->nullable();
            $table->integer('aju_app_keu_jbt_id')->nullable();
            $table->string('aju_app_keu_tanggal')->nullable();
            $table->string('aju_app_keu_status')->nullable();
            $table->text('aju_app_keu_keterangan')->nullable();
            $table->integer('aju_app_dir_jbt_id')->nullable();
            $table->string('aju_app_dir_tanggal')->nullable();
            $table->string('aju_app_dir_status')->nullable();
            $table->text('aju_app_dir_keterangan')->nullable();
            $table->string('is_complete')->nullable();
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
        Schema::dropIfExists('t_approval_pengajuan');
    }
};
