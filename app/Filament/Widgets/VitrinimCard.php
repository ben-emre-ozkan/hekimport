<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class VitrinimCard extends Widget
{
    protected static string $view = 'filament.widgets.vitrinim-card';
    protected int | string | array $columnSpan = 'full';
    
    public static function canView(): bool
    {
        return auth()->check();
    }
} 