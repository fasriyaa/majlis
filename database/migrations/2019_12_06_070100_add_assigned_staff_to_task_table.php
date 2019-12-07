<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignedStaffToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('tasks', 'staff')) {
        Schema::table('tasks', function($table) {
        $table->integer('staff')->nullable()->after('duration');
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
      $table->dropColumn('staff');
     });
    }
}
