<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('links')) {
          Schema::create('links', function (Blueprint $table) {
              $table->bigIncrements('id');
              $table->integer('source');
              $table->integer('target');
              $table->string('type');
              $table->integer('lag')->nullable();
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
        Schema::dropIfExists('links');
    }
}
