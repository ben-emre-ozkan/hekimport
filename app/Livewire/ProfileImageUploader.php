<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileImageUploader extends Component
{
    use WithFileUploads;

    public $photo;
    public $croppedPhoto;
    public $vitrin;
    public $showCropper = false;
    public $cropData = [
        'x' => 0,
        'y' => 0,
        'width' => 200,
        'height' => 200,
        'rotate' => 0,
        'scaleX' => 1,
        'scaleY' => 1
    ];

    public function mount(Vitrin $vitrin)
    {
        $this->vitrin = $vitrin;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:10240', // 10MB max
        ]);
        $this->showCropper = true;
    }

    public function crop()
    {
        $this->validate([
            'photo' => 'required|image|max:10240',
        ]);

        // Get the image
        $image = Image::make($this->photo->getRealPath());

        // Apply crop
        $image->crop(
            (int)$this->cropData['width'],
            (int)$this->cropData['height'],
            (int)$this->cropData['x'],
            (int)$this->cropData['y']
        );

        // Apply rotation if needed
        if ($this->cropData['rotate'] != 0) {
            $image->rotate($this->cropData['rotate']);
        }

        // Save the cropped image
        $path = 'profile-photos/' . $this->vitrin->id . '/' . time() . '.jpg';
        Storage::disk('public')->put($path, $image->encode('jpg', 80));

        // Clear previous profile photos
        $this->vitrin->clearMediaCollection('profile_photos');

        // Add the new photo to media collection
        $this->vitrin->addMediaFromDisk($path, 'public')
            ->usingName('Profile Photo')
            ->toMediaCollection('profile_photos');

        // Clean up
        Storage::disk('public')->delete($path);
        $this->photo = null;
        $this->showCropper = false;
        $this->dispatch('profile-photo-updated');
    }

    public function cancelCrop()
    {
        $this->photo = null;
        $this->showCropper = false;
    }

    public function render()
    {
        return view('livewire.profile-image-uploader');
    }
} 