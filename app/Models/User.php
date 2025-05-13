<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithMedia;
    use HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language',
        'timezone',
        'contact_email',
        'assigned_doctor_id',
        'signature',
        'is_banned_from_forum',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned_from_forum' => 'boolean',
        ];
    }

    /**
     * Get the vitrin associated with the user.
     */
    public function vitrin(): HasOne
    {
        return $this->hasOne(Vitrin::class);
    }

    /**
     * Get the doctor that this user is assigned to (for personel).
     */
    public function assignedDoctor()
    {
        return $this->belongsTo(User::class, 'assigned_doctor_id');
    }

    /**
     * Get the personel assigned to this doctor.
     */
    public function personel()
    {
        return $this->hasMany(User::class, 'assigned_doctor_id');
    }

    // Forum relationships
    public function forumMessages(): HasMany
    {
        return $this->hasMany(ForumMessage::class);
    }

    public function getMessageCountAttribute(): int
    {
        return $this->forumMessages()->count();
    }

    public function forumTopicReads(): HasMany
    {
        return $this->hasMany(ForumTopicUserRead::class);
    }

    public function lastReadAt(int $topicId): ?string
    {
        $read = $this->forumTopicReads()->where('topic_id', $topicId)->first();
        return $read ? $read->last_read_at : null;
    }
}
