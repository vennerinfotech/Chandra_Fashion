<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'image',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        // Check if image exists and file exists in public path
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // Return default image
        return asset('images/cf-logo-1.png');
    }
}
