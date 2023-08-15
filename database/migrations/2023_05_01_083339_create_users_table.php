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
        Schema::create('m_user', function (Blueprint $table) {
            $table->bigIncrements('usr_id');
            $table->unsignedBigInteger('kry_id');
            $table->foreign('kry_id')->references('kry_id')->on('m_karyawan');
            $table->string('usr_login');
            $table->string('usr_email')->nullable();
            $table->enum('usr_hak_akses', ['karyawan', 'administrator', 'keuangan', 'dikreksi', 'verifikasi'])->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('usr_password');
            $table->string('token');
            $table->rememberToken();
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
        Schema::dropIfExists('m_user');
    }
};
