<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('m_jenis_approval', function (Blueprint $table) {
            $table->bigIncrements('app_id');
            $table->string('app_jenis');
            $table->string('app_nama');
            $table->integer('app_min_nom');
            $table->integer('app_max_nom');
            $table->timestamps();
        });

        DB::table('m_jenis_approval')->insert([
            ['app_jenis' => 'app_verifikasi', 'app_nama' => 'Verifikasi', 'app_min_nom' => 0, 'app_max_nom' => 500000, 'created_at' => '2023-06-05 12:27:21', 'updated_at' => '2023-06-05 12:27:21'],
            ['app_jenis' => 'app_keuangan', 'app_nama' => 'Keuangan', 'app_min_nom' => 500001, 'app_max_nom' => 2000000, 'created_at' => '2023-06-05 12:27:36', 'updated_at' => '2023-06-05 12:27:36'],
            ['app_jenis' => 'app_direksi', 'app_nama' => 'Direksi', 'app_min_nom' => 2000001, 'app_max_nom' => 999999999, 'created_at' => '2023-06-05 12:27:59', 'updated_at' => '2023-07-02 11:38:53'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jenis_approval');
    }
};
