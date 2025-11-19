<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'details',
        'order',
        'facebook',
        'instagram',
        'linkedin',
        'twitter',
        'youtube'
    ];
}
