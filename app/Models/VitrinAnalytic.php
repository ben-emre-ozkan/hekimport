<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitrinAnalytic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vitrin_id',
        'metric',
        'value',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'integer',
        'date' => 'date',
    ];

    /**
     * Get the vitrin that owns the analytic.
     */
    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class);
    }

    /**
     * Scope a query to only include analytics for a specific metric.
     */
    public function scopeMetric($query, string $metric)
    {
        return $query->where('metric', $metric);
    }

    /**
     * Scope a query to only include analytics within a date range.
     */
    public function scopeDateRange($query, string $start, string $end)
    {
        return $query->whereBetween('date', [$start, $end]);
    }
}
