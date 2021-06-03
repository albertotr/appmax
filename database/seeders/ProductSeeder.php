<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Papel',
            'sku' => Str::random(5),
            'quantity' => 10
        ]);

        DB::table('products')->insert([
            'name' => 'Plastico',
            'sku' => Str::random(5),
            'quantity' => 235
        ]);
    }
}
