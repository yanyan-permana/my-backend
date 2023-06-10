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
        Schema::table('m_karyawan', function(Blueprint $table) {
            $table->renameColumn('id', 'kry_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_karyawan', function(Blueprint $table) {
            $table->renameColumn('kry_id', 'id');
        });
    }
};
