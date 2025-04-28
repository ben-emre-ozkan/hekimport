<?php

namespace App\Livewire;

use Livewire\Component;

class VitrinimPage extends Component
{
    public string $tab = 'profile'; // Default tab

    // Allow updating the tab via wire:click
    protected $queryString = [
        'tab' => ['except' => 'profile']
    ];

    public function render()
    {
        // Pass the active tab to the view if needed, though handled in view logic
        return view('livewire.vitrinim-page');
    }
}
