<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'date',
        'service_id',
        'status',
        // Add 'vitrin_id' if appointments belong to a specific Vitrin
        // 'vitrin_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime', // Cast date to datetime object
    ];

    // Define relationships if necessary (e.g., belongsTo Service, belongsTo Vitrin)
    // public function service()
    // {
    //     return $this->belongsTo(Service::class);
    // }
}
