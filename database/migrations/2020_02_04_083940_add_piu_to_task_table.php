<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPiuToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('tasks', 'piu_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->integer('piu_id')->after('staff')->nullable();
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

            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('piu_id');
            });

    }
}
