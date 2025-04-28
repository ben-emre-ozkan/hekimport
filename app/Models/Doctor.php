<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'specialty',
        'is_featured',
        'city',
        'profile_image',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function getProfileImageAttribute($value)
    {
        return $value ?: null;
    }
} 