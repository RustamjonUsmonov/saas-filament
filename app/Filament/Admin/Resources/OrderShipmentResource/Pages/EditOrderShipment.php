<?php

namespace App\Filament\Admin\Resources\OrderShipmentResource\Pages;

use App\Filament\Admin\Resources\OrderShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderShipment extends EditRecord
{
    protected static string $resource = OrderShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
