<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBudgetToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tasks', 'budget')) {
              Schema::table('tasks', function (Blueprint $table) {
              $table->double('budget')->nullable()->after('staff');
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
          Schema::table('tasks', function($table) {
          $table->dropColumn('budget');
     });
    }
}
