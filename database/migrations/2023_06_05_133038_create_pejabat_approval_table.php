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
        Schema::create('m_pejabat_approval', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('m_jenis_approval');
            $table->unsignedBigInteger('usr_id'); 
            $table->foreign('usr_id')->references('usr_id')->on('m_user');
            $table->string('app_auth_user');
            $table->string('app_auth_password');
            $table->string('pjbt_status');
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
        Schema::dropIfExists('m_pejabat_approval');
    }
};
