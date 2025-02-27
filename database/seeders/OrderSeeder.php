<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $statuses = OrderStatus::pluck('id')->toArray();

        // Create 10 orders
        foreach (range(1, 10) as $index) {
            $order = Order::create([
                'user_id' => $users[array_rand($users)], // Random user ID
                'order_status_id' => $statuses[array_rand($statuses)], // Random order status
                'total_amount' => fake()->randomFloat(2, 20, 500), // Random total amount between 20 and 500
            ]);

            // Create 1 to 3 order items for each order
            foreach (range(1, rand(1, 3)) as $itemIndex) {
                $order->items()->create([
                    'product_id' => 1, // Random product ID (modify as needed)
                    'product_variant_id' => rand(1, 2), // Random product variant ID (modify as needed)
                    'quantity' => rand(1, 5), // Random quantity between 1 and 5
                    'price' => fake()->randomFloat(2, 5, 100), // Random price per item between 5 and 100
                ]);
            }
        }
    }
}
