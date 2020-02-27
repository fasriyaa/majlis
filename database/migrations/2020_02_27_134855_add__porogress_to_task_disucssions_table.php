<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPorogressToTaskDisucssionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('task_discussions', 'progress')) {
            Schema::table('task_discussions', function (Blueprint $table) {
                $table->double('progress')->after('task_id')->nullable();
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
            $table->dropColumn('progress');
        });
    }
}
