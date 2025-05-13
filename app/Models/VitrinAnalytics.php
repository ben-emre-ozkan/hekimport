<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitrinAnalytics extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vitrin_id',
        'event_type',
        'source',
        'ip_address',
        'user_agent',
        'page',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'json',
    ];

    /**
     * Get the vitrin that this analytics record belongs to.
     */
    public function vitrin()
    {
        return $this->belongsTo(Vitrin::class);
    }
} 