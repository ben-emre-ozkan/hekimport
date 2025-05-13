<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'vitrin_id',
        'url',
        'title',
        'meta_description',
        'score',
        'issues',
        'recommendations',
        'last_scanned_at',
        'status',
    ];

    protected $casts = [
        'issues' => 'array',
        'recommendations' => 'array',
        'last_scanned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class);
    }

    public function getScoreColorAttribute(): string
    {
        return match(true) {
            $this->score >= 80 => 'green',
            $this->score >= 50 => 'yellow',
            default => 'red',
        };
    }
} 