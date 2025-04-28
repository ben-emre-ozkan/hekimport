<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;

class MasamDashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.masam-dashboard';
    protected static ?string $title = 'Masam';
    
    // Set the slug for the dashboard explicitly
    protected static ?string $slug = 'dashboard';
    
    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\VitrinimCard::class,
            \App\Filament\Widgets\KlinigimCard::class,
        ];
    }
    
    public function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\AnalyticsSummary::class,
        ];
    }
    
    protected function getHeaderView(): ?View
    {
        return FilamentView::make('filament.pages.masam-header')
            ->with([
                'user' => auth()->user(),
            ]);
    }
} 