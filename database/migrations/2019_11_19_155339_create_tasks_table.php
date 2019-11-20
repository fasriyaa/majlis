<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(! Schema::hasTable('tasks')) {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->DateTime('start_date')->nullable();
            $table->string('text');
            $table->float('progress')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('sortorder')->default(0);
            $table->integer('parent')->nullable();
            $table->string('type')->nullable();
            $table->boolean('readonly')->nullable();
            $table->boolean('editable')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
