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
        Schema::table('t_approval_pengajuan', function (Blueprint $table) {
            $table->renameColumn('id', 'aju_app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_approval_pengajuan', function (Blueprint $table) {
            $table->renameColumn('aju_app_id', 'id');
        });
    }
};
