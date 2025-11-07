<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     
       Product::factory(10)->create();

        //User::factory(5)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        // Assign roles (admin/trabajador)
        $this->call(RolesSeeder::class);


        //genera pedidos con productos
        Order::factory()->count(10)->withProducts(3)->create();
    }
}
