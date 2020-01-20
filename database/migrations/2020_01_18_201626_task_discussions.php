<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskDiscussions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(! Schema::hasTable('task_discussions')) {
          Schema::create('task_discussions', function (Blueprint $table) {
              $table->bigIncrements('id');
              $table->integer('discussion_id');
              $table->integer('task_id');
              $table->string('comment')->nullable();
              $table->string('next_step')->nullable();
              $table->integer('status')->default(1);
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
        Schema::dropIfExists('task_discussions');
    }
}
