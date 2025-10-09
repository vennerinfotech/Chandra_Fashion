<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'hero_image',
        'experience_years',
        'testimonial_text',
        'testimonial_author',
        'about_title',
        'about_subtitle',
        'paragraph1',
        'paragraph2',
        'why_title',
        'why_paragraph',
        'why_list',
        'stats',
        'team',
        'status',
        'why_choose_us_1',
        'why_choose_us_2',
        'why_choose_us_image'
    ];

    protected $casts = [
        'why_list' => 'array',
        'stats'    => 'array',
        'team'     => 'array',
        'status'   => 'boolean',
    ];
}
