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
            $table->id();
            $table->integer('aju_id');
            $table->integer('aju_app_ver_jbt_id');
            $table->string('aju_app_ver_tanggal');
            $table->string('aju_app_ver_status');
            $table->text('aju_app_ver_keterangan')->nullable();
            $table->integer('aju_app_keu_jbt_id');
            $table->string('aju_app_keu_tanggal');
            $table->string('aju_app_keu_status');
            $table->text('aju_app_keu_keterangan')->nullable();
            $table->integer('aju_app_dir_jbt_id');
            $table->string('aju_app_dir_tanggal');
            $table->string('aju_app_dir_status');
            $table->text('aju_app_dir_keterangan')->nullable();
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
