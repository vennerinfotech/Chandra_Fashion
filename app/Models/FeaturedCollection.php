<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FeaturedCollection extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'image'];
}
