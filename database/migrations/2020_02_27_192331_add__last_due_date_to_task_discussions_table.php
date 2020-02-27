<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastDueDateToTaskDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('task_discussions', 'last_due')) {
            Schema::table('task_discussions', function (Blueprint $table) {
                $table->date('last_due')->after('progress')->nullable();
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
        Schema::table('task_discussions', function (Blueprint $table) {
            $table->dropColumn('last_due');
        });
    }
}
