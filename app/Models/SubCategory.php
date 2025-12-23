<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'status', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        // Check if image exists and file exists in public path
        if ($this->image && file_exists(public_path('images/subcategories/' . $this->image))) {
            return asset('images/subcategories/' . $this->image);
        }

        // Return default image
        return asset('images/cf-logo-1.png');
    }
}
