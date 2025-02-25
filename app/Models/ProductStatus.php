<?php

namespace App\Models;

use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function getStatusColorAttribute()
    {
        return match (strtolower($this->name)) {
            'available' => Color::Green,
            'out of stock' => Color::Red,
            'draft' => Color::Yellow,
            default => Color::Gray,
        };
    }
}
