<?php

namespace App\Filament\Admin\Resources\PaymentResource\Pages;

use App\Filament\Admin\Resources\PaymentResource;
use App\Filament\Admin\Resources\PaymentResource\Widgets\PaymentOverview;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;


    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getHeaderWidgets(): array
    {
        return [
            PaymentOverview::class,
        ];
    }
}
