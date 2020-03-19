<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMeetingDateToDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('discussions', 'meeting_date')) {
        Schema::table('discussions', function (Blueprint $table) {
            $table->date('meeting_date')->after('last_meeting')->nullable();
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
      Schema::table('discussions', function (Blueprint $table) {
          $table->dropColumn('meeting_date');
      });
    }
}
