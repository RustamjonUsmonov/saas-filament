<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getStatusColorAttribute()
    {
        return match (strtolower($this->name)) {
            'pending payment' => Color::Yellow,    // 🟡 Yellow
            'processing' => Color::Amber,          // 🟠 Amber
            'confirmed' => Color::Green,           // 🟢 Green
            'shipped' => Color::Violet,            // 🟣 Violet
            'out for delivery' => Color::Blue,     // 🔵 Blue
            'delivered' => Color::Teal,            // 🟢 Teal
            'cancelled' => Color::Stone,           // ⚫ Stone (Neutral)
            'refunded' => Color::Neutral,          // ⚪ Neutral (Gray)
            'failed' => Color::Red,                // 🔴 Red
            'on hold' => Color::Orange,            // 🟠 Orange
            default => Color::Gray,                // ⚪ Default Gray
        };
    }
}
