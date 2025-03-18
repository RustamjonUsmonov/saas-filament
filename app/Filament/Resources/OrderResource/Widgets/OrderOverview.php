<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OrderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Get total orders and revenue
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        // Get pending orders
        $pendingOrders = Order::whereHas('status', fn($q) => $q->where('name', 'Processing'))->count();
        $deliveredTodayOrders = Order::whereHas('status', fn($q) => $q->where('name', 'Delivered')->where('updated_at', '>=', now()->startOfDay()))->count();

        // Get last 7 days of order count for chart
        $orderTrends = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count')
            ->toArray();

        // Ensure chart always has 7 values (default to 0 if missing)
        $chartData = array_pad($orderTrends, -7, 0);

        return [
            Stat::make('Total Orders', $totalOrders)
                ->description('All-time orders placed')
                ->color('primary')
                ->icon('heroicon-o-shopping-bag')
                ->chart($chartData),

            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('Total revenue from orders')
                ->color('success')
                ->icon('heroicon-o-banknotes')
                ->chart($chartData),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Orders awaiting processing')
                ->color('warning')
                ->icon('heroicon-o-clock')
                ->chart($chartData),

            Stat::make('Delivered Orders Today', $deliveredTodayOrders)
                ->description('Orders delivered today')
                ->color('secondary')
                ->icon('phosphor-truck')
                ->chart($chartData),
        ];
    }
}
