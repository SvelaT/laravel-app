<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
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
        // \App\Models\User::factory(10)->create();
        Product::factory(25)->create();
        User::create([
            'name' => 'Arturo',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'email' => 'arturo@gmail.com'
        ]);
        User::create([
            'name' => 'Bruno',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'email' => 'bruno@gmail.com'
        ]);
        User::create([
            'name' => 'Marcio',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'email' => 'marcio@gmail.com'
        ]);
        User::create([
            'name' => 'Eduardo',
            'password' => Hash::make('guest'),
            'role' => 'guest',
            'email' => 'eduardo@gmail.com'
        ]);
        User::factory(15)->create();
    }
}
