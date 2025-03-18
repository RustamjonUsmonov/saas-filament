<?php

namespace App\Filament\User\Resources\UserAddressResource\Pages;

use App\Filament\User\Resources\UserAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAddress extends CreateRecord
{
    protected static string $resource = UserAddressResource::class;
}
