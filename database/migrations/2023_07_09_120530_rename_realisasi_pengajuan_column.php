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
        // Schema::table('t_realisasi_pengajuan', function (Blueprint $table) {
        //     $table->renameColumn('id', 'real_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_realisasi_pengajuan', function (Blueprint $table) {
            $table->renameColumn('real_id', 'id');
        });
    }
};
