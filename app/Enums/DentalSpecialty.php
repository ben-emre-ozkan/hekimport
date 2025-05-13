<?php

declare(strict_types=1);

namespace App\Enums;

enum DentalSpecialty: string
{
    case GENERAL_DENTISTRY = 'genel_dis_hekimligi';
    case ORTHODONTICS = 'ortodonti';
    case PERIODONTICS = 'periodontoloji';
    case ENDODONTICS = 'endodonti';
    case ORAL_SURGERY = 'agiz_dis_ve_cene_cerrahisi';
    case PEDIATRIC_DENTISTRY = 'pedodonti';
    case PROSTHODONTICS = 'protetik_dis_tedavisi';
    case ORAL_RADIOLOGY = 'agiz_dis_ve_cene_radyolojisi';
    case RESTORATIVE_DENTISTRY = 'restoratif_dis_tedavisi';
    case IMPLANTOLOGY = 'implantoloji';
    case AESTHETIC_DENTISTRY = 'estetik_dis_hekimligi';

    public function getLabel(): string
    {
        return match($this) {
            self::GENERAL_DENTISTRY => 'Genel Diş Hekimliği',
            self::ORTHODONTICS => 'Ortodonti',
            self::PERIODONTICS => 'Periodontoloji',
            self::ENDODONTICS => 'Endodonti',
            self::ORAL_SURGERY => 'Ağız, Diş ve Çene Cerrahisi',
            self::PEDIATRIC_DENTISTRY => 'Pedodonti',
            self::PROSTHODONTICS => 'Protetik Diş Tedavisi',
            self::ORAL_RADIOLOGY => 'Ağız, Diş ve Çene Radyolojisi',
            self::RESTORATIVE_DENTISTRY => 'Restoratif Diş Tedavisi',
            self::IMPLANTOLOGY => 'İmplantoloji',
            self::AESTHETIC_DENTISTRY => 'Estetik Diş Hekimliği',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $specialty) => [$specialty->value => $specialty->getLabel()])
            ->toArray();
    }
} 