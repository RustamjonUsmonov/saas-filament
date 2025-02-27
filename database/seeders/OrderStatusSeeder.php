<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        // Array of real-life order statuses
        $statuses = [
            'Pending',
            'Processing',
            'Shipped',
            'Out for Delivery',
            'Delivered',
            'Canceled',
            'Returned',
            'Refunded',
            'Failed',
            'Completed'
        ];

        // Loop through each status and create a record
        foreach ($statuses as $status) {
            OrderStatus::create([
                'name' => $status
            ]);
        }
    }
}
