<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name','logo','email','phone','address',
        'footer_brand_name','footer_brand_desc','footer_facebook',
        'footer_instagram','footer_linkedin','footer_address',
        'footer_phone','footer_email','footer_copyright'
    ];
}
