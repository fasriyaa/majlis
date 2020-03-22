<?php

use Illuminate\Database\Seeder;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('document_types')->insert([
          ['id'=>1, 'name'=>'something'],
          ['id'=>2, 'name'=>'something'],
          ['id'=>3, 'name'=>'something'],
          ['id'=>4, 'name'=>'Contracts']

      ]);
    }
}
