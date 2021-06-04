<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Product;
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
        Product::create([
            'name' => 'Papel',
            'sku' => 'sku80',
            'quantity' => 10,
            'created_at' => Carbon::now()->subDays(30)
        ]);

        Product::create([
            'name' => 'Plastico',
            'sku' => 'sku13',
            'quantity' => 235,
            'created_at' => Carbon::now()->subDays(30)
        ]);
    }
}
