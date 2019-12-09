<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('task_approvals')) {
            Schema::create('task_approvals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('task_id');
                $table->integer('staff_id');
                $table->integer('approval_status')->default(0);
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
        Schema::dropIfExists('task_approvals');
    }
}
