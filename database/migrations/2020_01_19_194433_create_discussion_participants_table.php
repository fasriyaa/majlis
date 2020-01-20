<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('discussion_participants')) {
            Schema::create('discussion_participants', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('discussion_id');
                $table->integer('user_id');
                $table->timestamps();
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
        Schema::dropIfExists('discussion_participants');
    }
}
