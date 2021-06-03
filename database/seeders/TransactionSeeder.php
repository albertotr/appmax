<?php

namespace Database\Seeders;

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
        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '5',
            'product_id' => 1
        ]);

        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '100',
            'product_id' => 1
        ]);

        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '-45',
            'product_id' => 1
        ]);

        DB::table('transactions')->insert([
            'origin' => 'A',
            'amount' => '-50',
            'product_id' => 1
        ]);

        /**
         * product platico seed
         */
        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '1530',
            'product_id' => 2
        ]);

        DB::table('transactions')->insert([
            'origin' => 'A',
            'amount' => '-133',
            'product_id' => 2
        ]);

        DB::table('transactions')->insert([
            'origin' => 'A',
            'amount' => '-45',
            'product_id' => 2
        ]);

        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '40',
            'product_id' => 2
        ]);

        DB::table('transactions')->insert([
            'origin' => 'I',
            'amount' => '-1139',
            'product_id' => 2
        ]);
    }
}
