<?php

namespace App\Filament\Admin\Resources\ProductAttributeResource\Pages;

use App\Filament\Admin\Resources\ProductAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductAttribute extends EditRecord
{
    protected static string $resource = ProductAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
