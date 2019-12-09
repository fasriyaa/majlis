<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIDToApprovalTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          if (!Schema::hasColumn('task_approvals', 'user_id')) {
            Schema::table('task_approvals', function($table) {
            $table->integer('user_id')->after('staff_id');
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
      Schema::table('task_approvals', function($table) {
      $table->dropColumn('user_id');
     });
    }
}
