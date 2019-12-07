<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('timelines')) {
            Schema::create('timelines', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('text');
                $table->integer('task')->nullable();
                $table->integer('user');
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
        Schema::dropIfExists('timelines');
    }
}
