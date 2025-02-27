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
            'draft' => Color::Yellow,         // 🟡 Yellow
            'pending approval' => Color::Amber, // 🟠 Amber (Warm Orange)
            'active' => Color::Green,         // 🟢 Green (Mid-tone)
            'out of stock' => Color::Red,     // 🔴 Red (Mid-tone)
            'backordered' => Color::Purple,   // 🟣 Purple (Indicates waiting)
            'discontinued' => Color::Gray,    // ⚪ Gray (Neutral tone)
            'rejected' => Color::Red,         // 🔴 Darker Red (More severe)
            'hidden' => Color::Slate,         // 🌑 Slate Gray (Subtle)
            'pre-order' => Color::Blue,       // 🔵 Blue (Trustworthy)
            'archived' => Color::Zinc,        // ⚪ Muted Gray (Less emphasis)
            default => Color::Gray,           // Default to light gray
        };
    }
}
