<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsLog extends Model
{
    protected $fillable = [
        'vitrin_id',
        'phone',
        'message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class);
    }
} 