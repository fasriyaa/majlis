<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'organization')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('organization')->after('email')->nullable();
                $table->string('designation')->after('email')->nullable();
                $table->string('profile_pic')->after('email')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
              $table->dropColumn('organization');
              $table->dropColumn('designation');
              $table->dropColumn('profile_pic');
        });
    }
}
