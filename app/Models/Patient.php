<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'address',
        'city',
        'state',
        'zip',
        'notes',
        'status',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'notes' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user (doctor) that owns the patient.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vitrin that owns the patient.
     */
    public function vitrin(): BelongsTo
    {
        return $this->belongsTo(Vitrin::class, 'user_id', 'user_id');
    }
} 