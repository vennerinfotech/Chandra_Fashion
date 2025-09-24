<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','description','category','fabric','moq','export_ready','price',
        'image_url','colors','sizes','gallery','tags','sku','weight','weave',
        'thread_count','shrinkage','collar_type','cuff_style','buttons','fit','delivery_time'
    ];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
        'gallery' => 'array',
        'tags' => 'array',
        'export_ready' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

}
