<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heritage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'paragraph1',
        'paragraph2',
        'button_text',
        'image',
    ];
}
