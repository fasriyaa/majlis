<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeBasedPlanedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_based_planeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contract_id');
            $table->integer('rem_days');
            $table->double('rem_rate');
            $table->integer('perdiem_days')->nullable();
            $table->double('perdiem_rate')->nullable();
            $table->integer('trip_days')->nullable();
            $table->double('trip_rate')->nullable();
            $table->integer('transfer_days')->nullable();
            $table->double('transfer_rate')->nullable();
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
        Schema::dropIfExists('time_based_planeds');
    }
}
