<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vitrin extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'student_id',
        'subdomain',
        'title',
        'description',
        'image',
        'content',
        'working_hours',
        'services',
        'social_media',
        'contact_info',
        'custom_slug',
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
        'working_hours' => 'array',
        'services' => 'array',
        'social_media' => 'array',
        'contact_info' => 'array',
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

    public function getNameAttribute()
    {
        return $this->content['name'] ?? $this->subdomain;
    }

    public function getBioAttribute()
    {
        return $this->content['bio'] ?? '';
    }

    public function getCityAttribute()
    {
        return $this->content['location']['city'] ?? '';
    }

    public function getSpecialtyAttribute()
    {
        return $this->content['specialties'][0] ?? '';
    }

    /**
     * Register media collections for the model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photos')
            ->singleFile();
            
        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }
}
