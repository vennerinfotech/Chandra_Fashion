<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
     protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'materials',
        'export_ready',
        'price',
        'image',
        'delivery_time',
        'category_id'
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
        return $this->belongsTo(Subcategory::class);
    }
}

