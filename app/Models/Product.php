<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'materials',
        'moq',
        'export_ready',
        'price',
        'delivery_time',
        'image',
    ];

    protected $casts = [
        'export_ready' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

