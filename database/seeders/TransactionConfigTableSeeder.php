<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionConfig;

class TransactionConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionConfig::insert([
            ['currency_code' => 'EUR', 'max_amount' => '280'],
            ['currency_code' => 'GBP', 'max_amount' => '290'],
            ['currency_code' => 'USD', 'max_amount' => '300']
        ]);
    }
}
