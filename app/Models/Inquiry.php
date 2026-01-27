<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'company',
        'email',
        'phone',
        'quantity',
        'selected_size',
        'selected_images',
        'variant_details',
        'color',
        'country_id',
        'state_id',
        'city_id',
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

    // relationship with Country, State, and City
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
