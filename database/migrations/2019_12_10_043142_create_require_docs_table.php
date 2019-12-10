<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequireDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(! Schema::hasTable('require_docs')) {
          Schema::create('require_docs', function (Blueprint $table) {
              $table->bigIncrements('id');
              $table->integer('task_id');
              $table->string('doc_name')->nullable();
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
        Schema::dropIfExists('require_docs');
    }
}
