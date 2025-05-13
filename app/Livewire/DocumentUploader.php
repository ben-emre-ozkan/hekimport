<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Storage;

class DocumentUploader extends Component
{
    use WithFileUploads;

    public $document;
    public $vitrin;
    public $title;
    public $description;
    public $showUploader = false;

    public function mount(Vitrin $vitrin)
    {
        $this->vitrin = $vitrin;
    }

    public function updatedDocument()
    {
        $this->validate([
            'document' => 'file|max:51200', // 50MB max
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
    }

    public function saveDocument()
    {
        $this->validate([
            'document' => 'required|file|max:51200',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Add document to media collection
        $this->vitrin->addMedia($this->document->getRealPath())
            ->usingName($this->title)
            ->withCustomProperties([
                'description' => $this->description,
            ])
            ->toMediaCollection('documents');

        $this->document = null;
        $this->title = '';
        $this->description = '';
        $this->showUploader = false;
        $this->dispatch('documents-updated');
    }

    public function removeDocument($mediaId)
    {
        $media = $this->vitrin->getMedia('documents')->where('id', $mediaId)->first();
        if ($media) {
            $media->delete();
            $this->dispatch('documents-updated');
        }
    }

    public function render()
    {
        return view('livewire.document-uploader');
    }
} 