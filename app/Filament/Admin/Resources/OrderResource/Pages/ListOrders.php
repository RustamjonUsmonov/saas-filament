<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use App\Models\OrderStatus;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $statuses = OrderStatus::all();

        $tabs = [
            'all' => Tab::make()->label('All Orders')
                ->icon('phosphor-faders')
                ->modifyQueryUsing(fn (Builder $query) => $query),
        ];

        foreach ($statuses as $status) {
            $tabs[strtolower($status->name)] = Tab::make()
                ->label($status->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', $status->id));
        }

        return $tabs;
    }
}
