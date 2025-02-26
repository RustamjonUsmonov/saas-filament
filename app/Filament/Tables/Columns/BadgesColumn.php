<?php

namespace App\Filament\Tables\Columns;

use Closure;
use Filament\Tables\Columns\TextColumn;

class BadgesColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->badge();
    }

    public function limit(int|Closure|null $length = 3, string|Closure|null $end = null): static
    {
        $this->limitList($length);

        return $this;
    }
}
