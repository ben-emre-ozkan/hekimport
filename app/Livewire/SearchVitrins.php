<?php

namespace App\Livewire;

use App\Models\Vitrin;
use Livewire\Component;
use Livewire\WithPagination;

class SearchVitrins extends Component
{
    use WithPagination;

    public $query = '';
    public $city = '';
    public $specialty = '';
    public $cities = [];
    public $specialties = [];

    public function mount()
    {
        $this->cities = Vitrin::pluck('content->location->city')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        $this->specialties = Vitrin::pluck('content->specialties')
            ->flatten()
            ->unique()
            ->filter()
            ->values()
            ->toArray();
    }

    public function updated($property)
    {
        if (in_array($property, ['query', 'city', 'specialty'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $vitrins = Vitrin::search(
            $this->query,
            $this->city,
            $this->specialty
        );

        return view('livewire.search-vitrins', [
            'vitrins' => $vitrins,
        ]);
    }
} 