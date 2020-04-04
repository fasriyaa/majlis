<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('currencies')->insert([
          ['id'=>1, 'code'=>'MVR', 'name' => 'Maldivian Rufiyaa', 'xrate' => 15.30, 'status'=>1],
          ['id'=>2, 'code'=>'USD', 'name' => 'United States Dollar', 'xrate' => 1, 'status'=>1]
      ]);
    }
}
