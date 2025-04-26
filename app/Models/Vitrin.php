<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vitrin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'student_id',
        'subdomain',
        'content',
        'clinic_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the vitrin.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student that owns the vitrin.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the analytics for the vitrin.
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(VitrinAnalytic::class);
    }

    /**
     * Scope a query to only include active vitrins.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function search($query, $city = null, $specialty = null)
    {
        $searchQuery = self::query();

        if ($query) {
            $searchQuery->whereRaw(
                "MATCH(subdomain, content) AGAINST(? IN BOOLEAN MODE)",
                [$query]
            );
        }

        if ($city) {
            $searchQuery->whereJsonContains('content->location->city', $city);
        }

        if ($specialty) {
            $searchQuery->whereJsonContains('content->specialties', $specialty);
        }

        return $searchQuery->where('is_active', true)->paginate(10);
    }
}
