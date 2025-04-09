<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\IncomingStock;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Branch::create([
            'branch_name' => 'BRANCH A',
            'branch_code' => '001-1-1-1',
            'address' => 'jln bekisting mekarsari cimanggis depok',
            'city' => '1_Kabupaten Badung',
            'province' => '1_Bali',
            'sub_district' => '1_Abiansemal',
            'postal_code' => '80352',
            'phone_number' => '0812345678',
            'status' => 'active'
        ]);

        User::create([
            'user_name' => 'user',
            'email' => 'user@gmail.com',
            'password' => '12345678',
            'role' => 'super_admin',
            'position' => 'head branch',
            'branches_id' => 1,
            'phone_number' => '0812345678',
            'status' => 'active'
        ]);

        Category::create([
            'category_name' => 'makanan',
        ]);

        Product::create([
            'product_code' => '00130032025',
            'product_name' => 'oreo',
            'product_img' => 'product_img/2EZztZHcenXzjojuxfnEFX9m0LgnrM0bE408LNhh.png',
            'price' => 10000,
            'categories_id' => 1,
        ]);

        IncomingStock::create([
            'branches_id' => 1,
            'products_id' => 1,
            'initial_stocks' => 10,
            'current_stocks' => 10,
            'expired' => Carbon::now(),
        ]);
    }
}
