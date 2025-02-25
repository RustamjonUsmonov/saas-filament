<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'product_category_id',
        'name',
        'description',
        'price',
        'quantity',
        'product_status_id'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productStatus(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }
}
