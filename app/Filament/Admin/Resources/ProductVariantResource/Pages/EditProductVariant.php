<?php

namespace App\Filament\Admin\Resources\ProductVariantResource\Pages;

use App\Filament\Admin\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariant extends EditRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
