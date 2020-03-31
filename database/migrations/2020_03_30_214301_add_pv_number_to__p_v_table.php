<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPvNumberToPVTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('p_v_s', 'pv_no')) {
            Schema::table('p_v_s', function (Blueprint $table) {
                $table->string('pv_no')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_v_s', function (Blueprint $table) {
            $table->dropColumn('pv_no');
        });
    }
}
