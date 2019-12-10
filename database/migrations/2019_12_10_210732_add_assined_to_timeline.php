<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssinedToTimeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('timelines', 'type')) {
        Schema::table('timelines', function($table) {
        $table->integer('type')->nullable()->after('user');
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
          Schema::table('timelines', function($table) {
          $table->dropColumn('type');
         });
    }
}
