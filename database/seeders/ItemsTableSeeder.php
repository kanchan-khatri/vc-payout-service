<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => 1,  'name'=>'science book', 'currency_code'=>'USD', 'amount'=>100,'seller_id'=> 1]
            ['id' => 2,  'name'=>'EVS book', 'currency_code'=>'USD', 'amount'=>150,'seller_id'=> 1],
            ['id' => 3,  'name'=>'EVS book', 'currency_code'=>'EUR', 'amount'=>100,'seller_id'=> 1],
            ['id' => 4,  'name'=>'Geo book', 'currency_code'=>'USD', 'amount'=>65,'seller_id'=> 1],
            ['id' => 5,  'name'=>'Geo book', 'currency_code'=>'EUR', 'amount'=>60,'seller_id'=> 1],
            ['id' => 6,  'name'=>'Geo book', 'currency_code'=>'EUR', 'amount'=>67,'seller_id'=> 1],
            ['id' => 7,  'name'=>'English book', 'currency_code'=>'EUR', 'amount'=>112,'seller_id'=> 1],
            ['id' => 8,  'name'=>'English Dictionary', 'currency_code'=>'GBP', 'amount'=>120,'seller_id'=> 1],
            ['id' => 9,  'name'=>'French Dictionary', 'currency_code'=>'EUR', 'amount'=>120,'seller_id'=> 2],
            ['id' => 10, 'name'=>'French Dictionary', 'currency_code'=>'USD', 'amount'=>120,'seller_id'=> 2],
            ['id' => 11, 'name'=>'Math Book', 'currency_code'=>'USD', 'amount'=>120,'seller_id'=> 4],
            ['id' => 12, 'name'=>'Math Book', 'currency_code'=>'EUR', 'amount'=>110,'seller_id'=> 4],
            ['id' => 13, 'name'=>'Math Book', 'currency_code'=>'GBP', 'amount'=>120,'seller_id'=> 4],
            ['id' => 14, 'name'=>'science book', 'currency_code'=>'GBP', 'amount'=>100,'seller_id'=> 1],
            ['id' => 15, 'name'=>'French Literature', 'currency_code'=>'GBP', 'amount'=>120,'seller_id'=> 3],
            ['id' => 16, 'name'=>'English Literature', 'currency_code'=>'EUR', 'amount'=>120,'seller_id'=> 5],
            ['id' => 17, 'name'=>'Algebra HSC', 'currency_code'=>'USD', 'amount'=>50,'seller_id'=> 6],
            ['id' => 18, 'name'=>'Algebra HSC', 'currency_code'=>'EUR', 'amount'=>40,'seller_id'=> 6]
        ];
        Item::insert($records);
    }
}