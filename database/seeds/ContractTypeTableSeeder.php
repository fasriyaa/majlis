<?php

use Illuminate\Database\Seeder;

class ContractTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('contract_types')->insert([
          ['id'=>1, 'name'=>'Dummy Contract', 'status'=>1],
          ['id'=>2, 'name'=>'Consultancy', 'status'=>1],
          ['id'=>3, 'name'=>'Goods', 'status'=>1],
          ['id'=>4, 'name'=>'PFDS', 'status'=>1],
          ['id'=>5, 'name'=>'PMU', 'status'=>1]
      ]);

    }
}
