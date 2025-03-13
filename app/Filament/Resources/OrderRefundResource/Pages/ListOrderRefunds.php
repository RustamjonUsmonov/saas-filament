<?php

namespace App\Filament\Resources\OrderRefundResource\Pages;

use App\Filament\Resources\OrderRefundResource;
use App\Models\OrderRefundStatus;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrderRefunds extends ListRecords
{
    protected static string $resource = OrderRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $statuses = OrderRefundStatus::all();

        $tabs = [
            'all' => Tab::make()->label('All Refunds')
                ->icon('phosphor-faders')
                ->modifyQueryUsing(fn (Builder $query) => $query),
        ];

        foreach ($statuses as $status) {
            $tabs[strtolower($status->name)] = Tab::make()
                ->label($status->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('order_refund_status_id', $status->id));
        }

        return $tabs;
    }
}
