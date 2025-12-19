<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImportLog extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'total_rows',
        'processed_rows',
        'successful_rows',
        'failed_rows',
        'skipped_rows',
        'status',
        'started_at',
        'completed_at',
        'error_message',
        'session_key',
        'user_id',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
