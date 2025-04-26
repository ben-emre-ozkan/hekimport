<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\VitrinAnalytics;

class AnalyticsSummary extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $vitrin = $user->vitrin;
        
        if (!$vitrin) {
            return [
                Stat::make('Toplam Ziyaret', '0')
                    ->description('Vitrin oluşturarak ziyaretçi almaya başlayın')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('gray'),
                Stat::make('Toplam Tıklama', '0')
                    ->description('Vitrin oluşturarak tıklama almaya başlayın')
                    ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                    ->color('gray'),
                Stat::make('Toplam Görüntülenme', '0')
                    ->description('Vitrin oluşturarak görüntülenme almaya başlayın')
                    ->descriptionIcon('heroicon-m-eye')
                    ->color('gray'),
            ];
        }
        
        $analytics = VitrinAnalytics::where('vitrin_id', $vitrin->id)
            ->selectRaw('metric, SUM(value) as total')
            ->groupBy('metric')
            ->get()
            ->pluck('total', 'metric')
            ->toArray();
            
        return [
            Stat::make('Toplam Ziyaret', number_format($analytics['visits'] ?? 0))
                ->description('Son 30 gün')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Toplam Tıklama', number_format($analytics['clicks'] ?? 0))
                ->description('Son 30 gün')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('warning'),
            Stat::make('Toplam Görüntülenme', number_format($analytics['impressions'] ?? 0))
                ->description('Son 30 gün')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),
        ];
    }
} 