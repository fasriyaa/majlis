<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalMatricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_matrices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('model');
            $table->integer('model_id');
            $table->integer('varification_check');
            $table->integer('varification_status');
            $table->integer('varification_id')->nullable();
            $table->integer('approval_check');
            $table->integer('approval_status');
            $table->integer('approval_id')->nullable();
            $table->integer('authorize_check');
            $table->integer('authorize_status');
            $table->integer('authorize_id')->nullable();
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
        Schema::dropIfExists('approval_matrices');
    }
}
