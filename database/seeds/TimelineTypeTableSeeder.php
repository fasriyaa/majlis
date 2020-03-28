<?php

use Illuminate\Database\Seeder;

class TimelineTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('timeline_types')->insert([
          ['id'=>1, 'name'=>'Task assinged to staff'],
          ['id'=>2, 'name'=>'Progress updated'],
          ['id'=>3, 'name'=>'New task'],
          ['id'=>4, 'name'=>'PIU review meetings'],
          ['id'=>5, 'name'=>'Task assinged to department'],
          ['id'=>6, 'name'=>'Documents related'],
          ['id'=>7, 'name'=>'Task approval'],
          ['id'=>8, 'name'=>'Comments to task'],
          ['id'=>9, 'name'=>'Budget'],
          ['id'=>10, 'name'=>'Contracts'],
          ['id'=>11, 'name'=>'Variations'],


      ]);
    }
}
