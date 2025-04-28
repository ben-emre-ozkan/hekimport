<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Collection;

class VitrinAnalytics extends Widget
{
    protected static string $view = 'filament.widgets.vitrin-analytics';
    protected int | string | array $columnSpan = 'full'; // Default to full width
    protected static ?int $sort = 3; // Sort order on dashboards, adjust as needed

    public Collection $analytics;
    public ?Vitrin $vitrin;

    public function mount(): void
    {
        $this->vitrin = Auth::user()?->vitrin;
        $this->analytics = $this->vitrin
            ? $this->vitrin->analytics()->latest('date')->latest('id')->take(10)->get() // Get latest 10 records
            : collect(); // Empty collection if no vitrin
    }

    // Optional: Make widget load lazily
    // public static function lazy(): bool
    // {
    //     return true;
    // }
} 