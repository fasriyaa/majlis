<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeBaseActualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_base_actuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_id');
            $table->integer('rem_days')->nullable();
            $table->integer('perdiem_days')->nullable();
            $table->integer('trip_days')->nullable();
            $table->double('trip_rate')->nullable();
            $table->integer('transfer_days')->nullable();
            $table->double('transfer_rate')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_base_actuals');
    }
}
