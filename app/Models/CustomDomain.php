<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'vitrin_id',
        'domain',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class);
    }
} 