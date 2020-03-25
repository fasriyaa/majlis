<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('permissions')->insert([
          ['name'=>'Create Variation','module' => 'Variations','guard_name'=>'web'],
          ['name'=>'Create Role','guard_name'=>'web']
      ]);
    }
}
