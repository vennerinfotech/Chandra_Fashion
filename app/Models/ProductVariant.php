<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'product_code', 'color', 'size', 'moq', 'images'
    ];

    protected $casts = [
        'images' => 'array',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImagesUrlAttribute()
    {
        if (!$this->images) return [];
        return collect($this->images)->map(fn($img) => asset($img))->toArray();
    }
}
