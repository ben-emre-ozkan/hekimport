<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'bio',
        'education',
        'experience',
        'certifications',
        'languages',
        'working_hours',
        'address',
        'phone',
        'website',
        'social_media',
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
        'working_hours' => 'array',
        'social_media' => 'array',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
} 