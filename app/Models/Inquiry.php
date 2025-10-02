<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'company',
        'email',
        'phone',
        'country',
        'quantity',
        'selected_size',
        'selected_images',
        'variant_details',
    ];

   protected $casts = [
        'selected_size' => 'array',
        'selected_images' => 'array',
        'variant_details' => 'array',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function firstVariant()
    {
        return $this->hasOne(ProductVariant::class, 'product_id', 'product_id')->orderBy('id');
    }

}
