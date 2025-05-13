<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ServiceGallery extends Component
{
    use WithFileUploads;

    public $photos = [];
    public $vitrin;
    public $showUploader = false;

    public function mount(Vitrin $vitrin)
    {
        $this->vitrin = $vitrin;
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:10240', // 10MB max per file
        ]);
    }

    public function savePhotos()
    {
        $this->validate([
            'photos.*' => 'required|image|max:10240',
        ]);

        foreach ($this->photos as $photo) {
            // Create a thumbnail
            $image = Image::make($photo->getRealPath());
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save the thumbnail
            $path = 'gallery/' . $this->vitrin->id . '/' . time() . '_' . $photo->getClientOriginalName();
            Storage::disk('public')->put($path, $image->encode('jpg', 80));

            // Add to media collection
            $this->vitrin->addMediaFromDisk($path, 'public')
                ->usingName($photo->getClientOriginalName())
                ->toMediaCollection('gallery');

            // Clean up
            Storage::disk('public')->delete($path);
        }

        $this->photos = [];
        $this->showUploader = false;
        $this->dispatch('gallery-updated');
    }

    public function removePhoto($mediaId)
    {
        $media = $this->vitrin->getMedia('gallery')->where('id', $mediaId)->first();
        if ($media) {
            $media->delete();
            $this->dispatch('gallery-updated');
        }
    }

    public function render()
    {
        return view('livewire.service-gallery');
    }
} 