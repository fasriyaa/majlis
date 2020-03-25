<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->date('recieved_date');
            $table->integer('terms_days');
            $table->integer('contract_id')->nullable();
            $table->integer('deliverable_linik')->nullable();
            $table->double('amount');
            $table->double('advanc_recovery')->nullable();
            $table->double('retention')->nullable();
            $table->integer('pv_id');
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
        Schema::dropIfExists('invoices');
    }
}
