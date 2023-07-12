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
        Schema::create('t_bukti', function (Blueprint $table) {
            $table->unsignedBigInteger('bkt_id')->primary();
            $table->integer('trans_id');
            $table->integer('trans_jns');
            $table->string('bkt_file_nama');
            $table->string('bkt_mime_tipe');
            $table->string('bkt_orig_nama');
            $table->string('bkt_file_ukuran');
            $table->string('bkt_file_folder');
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
        Schema::dropIfExists('t_bukti');
    }
};
