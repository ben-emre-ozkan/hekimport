<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Vitrin;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0))
            ->add(Url::create('/akademi')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create('/masa')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create('/masa/vitrinim')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create('/masa/klinik')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));

        // Add all active vitrins
        Vitrin::where('is_active', true)->get()->each(function ($vitrin) use ($sitemap) {
            $sitemap->add(
                Url::create("https://{$vitrin->subdomain}.hekimport.com")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully!');
    }
} 