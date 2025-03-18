<?php

namespace App\Filament\Admin\Resources\PaymentResource\Widgets;

use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Payments', Payment::count())
                ->description('Total payments recorded')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Total Amount', '$' . number_format(Payment::sum('amount'), 2))
                ->description('Total revenue from payments')
                ->icon('heroicon-o-banknotes')
                ->color('primary'),

            Stat::make('Pending Payments', Payment::where('status', 'Pending')->count())
                ->description('Payments yet to be processed')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}
