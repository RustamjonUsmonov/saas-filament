<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductStatus;

class ProductStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Draft'],
            ['name' => 'Pending Approval'],
            ['name' => 'Active'],
            ['name' => 'Out of Stock'],
            ['name' => 'Backordered'],
            ['name' => 'Discontinued'],
            ['name' => 'Rejected'],
            ['name' => 'Hidden'],
            ['name' => 'Pre-Order'],
            ['name' => 'Archived'],
        ];

        foreach ($statuses as $status) {
            ProductStatus::firstOrCreate($status);
        }
    }
}

