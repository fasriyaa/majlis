<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentsToTaskApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          if (!Schema::hasColumn('task_approvals', 'comment')) {
            Schema::table('task_approvals', function($table) {
            $table->LONGTEXT('comment')->nullable()->after('user_id');
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
          $table->dropColumn('comment');
         });
        }
}
