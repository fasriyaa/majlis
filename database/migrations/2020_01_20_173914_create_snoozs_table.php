<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnoozsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('snooz')) {
            Schema::create('snoozs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('task_id');
                $table->integer('discussion_id');
                $table->integer('discussion_cat_id');
                $table->date('start_date');
                $table->date('end_date');
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
        Schema::dropIfExists('snoozs');
    }
}
