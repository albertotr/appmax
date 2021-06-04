<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * products papel seed
         */
        Transaction::create([
            'origin' => 'I',
            'amount' => '5',
            'product_id' => 1,
            'created_at' => Carbon::now()->subDays(2)
        ]);

        Transaction::create([
            'origin' => 'I',
            'amount' => '100',
            'product_id' => 1,
            'created_at' => Carbon::now()->subDays(1)
        ]);

        Transaction::create([
            'origin' => 'I',
            'amount' => '-45',
            'product_id' => 1,
            'created_at' => Carbon::now()->subDays(1)
        ]);

        Transaction::create([
            'origin' => 'A',
            'amount' => '-50',
            'product_id' => 1
        ]);

        /**
         * product platico seed
         */
        Transaction::create([
            'origin' => 'I',
            'amount' => '1530',
            'product_id' => 2,
            'created_at' => Carbon::now()->subDays(3)
        ]);

        Transaction::create([
            'origin' => 'A',
            'amount' => '-133',
            'product_id' => 2,
            'created_at' => Carbon::now()->subDays(2)
        ]);

        Transaction::create([
            'origin' => 'A',
            'amount' => '-45',
            'product_id' => 2,
            'created_at' => Carbon::now()->subDays(1)
        ]);

        Transaction::create([
            'origin' => 'I',
            'amount' => '40',
            'product_id' => 2,
            'created_at' => Carbon::now()->subDays(1)
        ]);

        Transaction::create([
            'origin' => 'I',
            'amount' => '-1139',
            'product_id' => 2
        ]);
    }
}
