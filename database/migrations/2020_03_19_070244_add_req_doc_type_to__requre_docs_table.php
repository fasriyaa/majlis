<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReqDocTypeToRequreDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('require_docs', 'req_doc_type')) {
            Schema::table('require_docs', function (Blueprint $table) {
                $table->integer('req_doc_type')->after('id')->nullable();
                $table->string('alias_name')->after('doc_name')->nullable();
                $table->date('doc_date')->after('doc_name')->nullable();
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
        Schema::table('require_docs', function (Blueprint $table) {
            $table->dropColumn('req_doc_type');
            $table->dropColumn('alias_name');
            $table->dropColumn('doc_date');
        });
    }
}
