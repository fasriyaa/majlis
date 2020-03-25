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
          ['id'=>2, 'name'=>'Consultancy Service', 'status'=>1],
          ['id'=>3, 'name'=>'Non-Consultancy Service', 'status'=>1],
          ['id'=>4, 'name'=>'Goods', 'status'=>1],
          ['id'=>5, 'name'=>'Training', 'status'=>1],
          ['id'=>6, 'name'=>'Incremental Operating Cost', 'status'=>1],
          ['id'=>7, 'name'=>'PFDS', 'status'=>1],
          ['id'=>8, 'name'=>'PMU', 'status'=>1]
      ]);

    }
}
