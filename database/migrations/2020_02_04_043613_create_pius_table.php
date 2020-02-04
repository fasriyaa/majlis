<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('pius')) {
            Schema::create('pius', function (Blueprint $table) {
                  $table->bigIncrements('id');
                  $table->string('name');
                  $table->string('short_name');
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
        Schema::dropIfExists('pius');
    }
}
