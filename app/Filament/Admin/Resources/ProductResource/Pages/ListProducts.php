<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use App\Models\ProductStatus;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $statuses = ProductStatus::all();

        $tabs = [
            'all' => Tab::make()->label('All Products')
                ->icon('phosphor-faders')
                ->modifyQueryUsing(fn (Builder $query) => $query),
        ];

        foreach ($statuses as $status) {
            $tabs[strtolower($status->name)] = Tab::make()
                ->label($status->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('product_status_id', $status->id));
        }

        return $tabs;
    }
}
