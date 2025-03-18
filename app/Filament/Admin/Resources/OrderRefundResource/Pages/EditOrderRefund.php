<?php

namespace App\Filament\Admin\Resources\OrderRefundResource\Pages;

use App\Filament\Admin\Resources\OrderRefundResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderRefund extends EditRecord
{
    protected static string $resource = OrderRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
