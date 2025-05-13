<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Vitrin;
use Illuminate\Support\Facades\Schema; // Import Schema facade
use Illuminate\Support\Facades\Log; // Optional: for logging errors
use Illuminate\Database\Eloquent\Collection; // Import Collection
use Livewire\Component;

class FeaturedDoctors extends Component
{
    public array $doctors = []; // Changed to array for consistent format with the search page

    public function mount(): void
    {
        // Check if necessary tables exist before querying
        if (Schema::hasTable('vitrins') && Schema::hasTable('users')) {
            try {
                // Get active vitrins with their users
                $vitrins = Vitrin::where('is_active', true)
                    ->with('user')
                    ->take(4)
                    ->get();
                
                // Transform vitrins to the doctor format expected by the doctor-card component
                $this->doctors = $vitrins->map(function($vitrin) {
                    return [
                        'id' => $vitrin->user->id ?? 0,
                        'name' => $vitrin->user->name ?? 'Unknown Doctor',
                        'email' => $vitrin->user->email ?? '',
                        'specialty' => $vitrin->title ?? 'Diş Hekimi',
                        'city' => $vitrin->content['location']['city'] ?? 'Unknown',
                        'profile_image' => $vitrin->user->profile_photo_path ?? null,
                        'vitrin_url' => url($vitrin->subdomain),
                        'is_featured' => true
                    ];
                })->toArray();
            } catch (\Exception $e) {
                // Log the error if something goes wrong during the query
                Log::error('Error fetching featured doctors: ' . $e->getMessage());
                // Keep $this->doctors as an empty array
            }
        } else {
            Log::warning('FeaturedDoctors: Required tables (vitrins, users) not found. Skipping query.');
        }
    }

    public function render()
    {
        return view('livewire.featured-doctors');
    }
}
