<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'care_instructions',
        'materials',
        'export_ready',
        'price',
        'image',
        'delivery_time',
        'category_id',
        'subcategory_id'
    ];

    protected $casts = [
        'export_ready' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(\App\Models\ProductVariant::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function getImageUrlAttribute()
    {
        // Check if image exists and file exists in public path
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // Return default image
        return asset('images/cf-logo-1.png');  // Adjust path if inside public/images
    }
}
