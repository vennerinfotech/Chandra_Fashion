<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'btn1_text',
        'btn1_link',
        'btn2_text',
        'btn2_link',
        'btn3_text',
        'btn3_link',
        'background_image',
    ];
}
