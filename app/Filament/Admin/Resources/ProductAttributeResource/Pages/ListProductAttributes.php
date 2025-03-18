<?php

namespace App\Filament\Admin\Resources\ProductAttributeResource\Pages;

use App\Filament\Admin\Resources\ProductAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductAttributes extends ListRecords
{
    protected static string $resource = ProductAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
