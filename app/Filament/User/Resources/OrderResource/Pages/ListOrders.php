<?php

namespace App\Filament\User\Resources\OrderResource\Pages;

use App\Filament\User\Resources\OrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newOrder')
                ->label('New Order')
                ->url('/')
        ];
    }
    public function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\OrderOverview::class,
        ];
    }
}
