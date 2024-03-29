<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "default",
            'email' => "default@test.com",
            'password' => Hash::make('password'),
        ]);

        $this->call([
            ProductSeeder::class,
            TransactionSeeder::class
        ]);
    }
}
