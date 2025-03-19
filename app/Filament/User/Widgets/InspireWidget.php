<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;

class InspireWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.inspire-widget';

    protected function getViewData(): array
    {
        $quote = Cache::remember('quote',60,function (){
            return Inspiring::quotes()->random();
        });
        return ['quote'=>$quote];
    }
}
