<?php

namespace App\Filament\Admin\Resources\OrderReturnResource\Pages;

use App\Filament\Admin\Resources\OrderReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderReturn extends EditRecord
{
    protected static string $resource = OrderReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
