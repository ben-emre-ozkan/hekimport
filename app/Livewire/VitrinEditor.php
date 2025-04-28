<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vitrin;
use App\Models\User; // Import User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media; // Keep for potential future use

class VitrinEditor extends Component
{
    use WithFileUploads;

    public ?Vitrin $vitrin = null; // Hold the Vitrin model instance

    // Form properties
    public $bio = '';
    public $city = '';
    public $address = '';
    public $specialties = ''; // Comma-separated string for input
    public $working_hours = []; // Array for editing
    public $services = ''; // Comma-separated string for input
    public $social_media = ['instagram' => '', 'linkedin' => ''];
    public $contact_info = ['phone' => '', 'email' => ''];
    public $subdomain = ''; // Use subdomain as the primary identifier/slug
    public $photo; // For upload

    // Define default working hours structure
    protected $defaultWorkingHours = [
        'Pazartesi' => '', 'Salı' => '', 'Çarşamba' => '', 'Perşembe' => '',
        'Cuma' => '', 'Cumartesi' => '', 'Pazar' => ''
    ];

    public function mount()
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            // Redirect or display error if not logged in
            // For now, let's assume middleware handles this, but good practice to check
            session()->flash('error', 'Bu sayfayı görüntülemek için giriş yapmalısınız.');
            return redirect()->route('login');
        }

        $user = Auth::user();
        // Load the user's vitrin or create a new instance if it doesn't exist
        // Use firstOrNew to avoid saving immediately if new
        $this->vitrin = Vitrin::firstOrNew(['user_id' => $user->id]);

        // Populate form fields from the loaded/new vitrin model
        $this->bio = $this->vitrin->content['bio'] ?? '';
        $this->city = $this->vitrin->content['location']['city'] ?? '';
        $this->address = $this->vitrin->content['location']['address'] ?? '';
        // Convert arrays back to comma-separated strings for form display
        $this->specialties = implode(', ', $this->vitrin->content['specialties'] ?? []);
        $this->services = implode(', ', $this->vitrin->services ?? []);
        // Merge existing hours with defaults to ensure all days are present
        $this->working_hours = array_merge($this->defaultWorkingHours, $this->vitrin->working_hours ?? []);
        $this->social_media = $this->vitrin->social_media ?? ['instagram' => '', 'linkedin' => ''];
        $this->contact_info = $this->vitrin->contact_info ?? ['phone' => '', 'email' => ''];
        $this->subdomain = $this->vitrin->subdomain ?? ''; // Use existing subdomain or empty
    }

    public function save()
    {
        if (!$this->vitrin) {
             session()->flash('error', 'Vitrin bilgisi yüklenemedi.');
             return;
        }

        $validatedData = $this->validate([
            'bio' => 'nullable|string|max:2000',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'specialties' => 'nullable|string', // Store as comma-separated, convert on save
            'services' => 'nullable|string', // Store as comma-separated, convert on save
            'working_hours.Pazartesi' => 'nullable|string|max:50',
            'working_hours.Salı' => 'nullable|string|max:50',
            'working_hours.Çarşamba' => 'nullable|string|max:50',
            'working_hours.Perşembe' => 'nullable|string|max:50',
            'working_hours.Cuma' => 'nullable|string|max:50',
            'working_hours.Cumartesi' => 'nullable|string|max:50',
            'working_hours.Pazar' => 'nullable|string|max:50',
            'social_media.instagram' => 'nullable|url|max:255',
            'social_media.linkedin' => 'nullable|url|max:255',
            'contact_info.phone' => 'nullable|string|max:25',
            'contact_info.email' => 'nullable|email|max:255',
            'subdomain' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9-]+$/', // Allow lowercase letters, numbers, and hyphens
                Rule::unique('vitrins', 'subdomain')->ignore($this->vitrin->id),
            ],
            'photo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Prepare data for saving
        $contentData = [
            'bio' => $validatedData['bio'],
            'location' => ['city' => $validatedData['city'], 'address' => $validatedData['address']],
            // Convert comma-separated strings to arrays, filter empty values
            'specialties' => array_filter(array_map('trim', explode(',', $validatedData['specialties'] ?? ''))),
        ];
        $servicesArray = array_filter(array_map('trim', explode(',', $validatedData['services'] ?? '')));
        // Filter out empty working hours before saving
        $filteredWorkingHours = array_filter($validatedData['working_hours']);

        // Use updateOrCreate or fill/save depending on whether vitrin existed
        $this->vitrin->fill([
            'content' => $contentData,
            'working_hours' => $filteredWorkingHours,
            'services' => $servicesArray,
            'social_media' => $validatedData['social_media'],
            'contact_info' => $validatedData['contact_info'],
            'subdomain' => $validatedData['subdomain'],
            // Ensure user_id is set if it's a new vitrin
            'user_id' => $this->vitrin->user_id ?? Auth::id(),
            // Set a default title if needed, maybe based on user name?
            'title' => $this->vitrin->title ?? (Auth::user()->name . ' Vitrini'),
            'is_active' => $this->vitrin->is_active ?? true, // Default to active
        ]);

        $this->vitrin->save(); // Save the changes

        // Handle photo upload
        if ($this->photo) {
            // Clear previous profile photos before adding new one
            $this->vitrin->clearMediaCollection('profile_photos');
            $this->vitrin->addMedia($this->photo->getRealPath())
                         ->usingName($this->photo->getClientOriginalName())
                         ->toMediaCollection('profile_photos'); // Use a specific collection name
        }

        $this->photo = null; // Clear the upload property

        session()->flash('message', 'Vitrin başarıyla güncellendi!');

        // Optionally, refresh data or redirect
        // $this->mount(); // Re-mount to refresh data
    }

    public function render()
    {
        // Get the URL of the first profile photo, if it exists
        $profilePhotoUrl = $this->vitrin?->getFirstMediaUrl('profile_photos');

        return view('livewire.vitrin-editor', [
            'profilePhotoUrl' => $profilePhotoUrl,
        ]);
    }
}
