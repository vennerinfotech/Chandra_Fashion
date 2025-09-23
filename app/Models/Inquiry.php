<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','name','company','email','phone','country','quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}
