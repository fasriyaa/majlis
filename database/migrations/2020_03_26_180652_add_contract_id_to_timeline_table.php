<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractIdToTimelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('timelines', 'contract_id')) {
            Schema::table('timelines', function (Blueprint $table) {
                $table->integer('contract_id')->after('task')->nullable();
                $table->integer('variation_id')->after('task')->nullable();
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
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn('contract_id');
            $table->dropColumn('variation_id');
        });
    }
}
