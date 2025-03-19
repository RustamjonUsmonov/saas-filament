<?php

namespace App\Filament\User\Resources\ReviewResource\Pages;

use App\Filament\User\Resources\ReviewResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newReview')
                ->label('New Review')
                ->url('/')
        ];
    }
}
