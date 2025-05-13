<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileVisit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vitrin_id',
        'ip_address',
        'user_agent',
        'referrer',
    ];

    /**
     * Get the vitrin that owns the visit.
     */
    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class);
    }
} 