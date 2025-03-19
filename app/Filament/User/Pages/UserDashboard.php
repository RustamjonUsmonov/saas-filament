<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Dashboard;
class UserDashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'phosphor-castle-turret';

    protected static ?string $title = 'Personal Dashboard';

    public function getTitle(): string
    {
        return ''; // Empty title
    }
}
