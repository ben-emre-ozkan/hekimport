<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Cache;

class SearchVitrins extends Component
{
    use WithPagination;

    public $query = '';
    public $city = '';
    public $specialty = '';
    public $loading = false;
    public $cities = [];
    public $specialties = [];

    protected $queryString = [
        'query' => ['except' => ''],
        'city' => ['except' => ''],
        'specialty' => ['except' => ''],
    ];

    public function mount()
    {
        $this->cities = Cache::remember('vitrin_cities', 3600, fn() => 
            Vitrin::distinct()->pluck('city')->filter()->values()->toArray()
        );
        
        $this->specialties = Cache::remember('vitrin_specialties', 3600, fn() => 
            Vitrin::distinct()->pluck('specialty')->filter()->values()->toArray()
        );
    }

    public function updatedQuery()
    {
        $this->resetPage();
        $this->loading = true;
    }

    public function updatedCity()
    {
        $this->resetPage();
        $this->loading = true;
    }

    public function updatedSpecialty()
    {
        $this->resetPage();
        $this->loading = true;
    }

    public function render()
    {
        $query = Vitrin::query();

        if ($this->query) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('specialty', 'like', '%' . $this->query . '%');
            });
        }

        if ($this->city) {
            $query->where('city', $this->city);
        }

        if ($this->specialty) {
            $query->where('specialty', $this->specialty);
        }

        $vitrins = $query->paginate(10);
        $this->loading = false;

        return view('livewire.search-vitrins', [
            'vitrins' => $vitrins,
        ]);
    }
} 