<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Support\Colors\Color;

class OrderStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function getStatusColorAttribute()
    {
        return match (strtolower($this->name)) {
            'pending' => Color::Yellow,         // 🟡 Yellow
            'processing' => Color::Amber,       // 🟠 Amber
            'shipped' => Color::Violet,          // 🟢 Green
            'out for delivery' => Color::Blue,  // 🔵 Blue
            'delivered' => Color::Teal,         // 🟢 Teal
            'canceled' => Color::Stone,           // 🔴 Red
            'returned' => Color::Purple,        // 🟣 Purple
            'refunded' => Color::Neutral,          // ⚪ Gray
            'failed' => Color::Red,             // 🔴 Red (Failed)
            'completed' => Color::Green,        // 🟢 Green
            default => Color::Gray,             // ⚪ Default Gray
        };
    }
}
