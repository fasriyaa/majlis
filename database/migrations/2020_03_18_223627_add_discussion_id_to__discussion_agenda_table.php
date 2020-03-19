<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscussionIdToDiscussionAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('discussion_agendas', 'discussion_id')) {
            Schema::table('discussion_agendas', function (Blueprint $table) {
                $table->integer('discussion_id')->after('id');
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
        Schema::table('discussion_agendas', function (Blueprint $table) {
            $table->dropColumn('discussion_id');
        });
    }
}
