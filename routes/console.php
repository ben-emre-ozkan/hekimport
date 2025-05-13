<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Vitrin;
use App\Models\SeoReport;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule SEO report generation for all active vitrin profiles
Schedule::command('seo:analyze-all')->weekly()->wednesdays()->at('02:00')
    ->description('Generate SEO reports for all active profiles');

// Helper functions for SEO analysis
if (!function_exists('extractIssues')) {
    function extractIssues(array $data): array {
        $issues = [];
        
        foreach ($data as $key => $item) {
            if (is_array($item) && isset($item['status']) && $item['status'] === false) {
                $issues[$key] = isset($item['recommendation']) ? $item['recommendation'] : '';
            }
        }
        
        return $issues;
    }
}

if (!function_exists('extractRecommendations')) {
    function extractRecommendations(array $data): array {
        $recommendations = [];
        
        foreach ($data as $key => $item) {
            if (is_array($item) && isset($item['recommendation'])) {
                $recommendations[$key] = $item['recommendation'];
            }
        }
        
        return $recommendations;
    }
}

// Command to analyze SEO for all active vitrin profiles
Artisan::command('seo:analyze-all', function () {
    $this->info('Starting SEO analysis for all active profiles...');
    
    $vitrins = Vitrin::where('is_active', true)->get();
    $count = 0;
    
    foreach ($vitrins as $vitrin) {
        try {
            // Call the SEO analysis endpoint
            $response = Http::get(route('vitrin.seo-analysis', $vitrin->id));
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Create or update the SEO report
                SeoReport::updateOrCreate(
                    ['vitrin_id' => $vitrin->id],
                    [
                        'user_id' => $vitrin->user_id,
                        'url' => "https://{$vitrin->subdomain}.hekimport.com",
                        'title' => $vitrin->title ?? '',
                        'meta_description' => isset($vitrin->content['bio']) ? substr($vitrin->content['bio'], 0, 160) : '',
                        'score' => isset($data['score']) ? $data['score'] : 0,
                        'issues' => json_encode(extractIssues($data)),
                        'recommendations' => json_encode(extractRecommendations($data)),
                        'status' => 'completed',
                        'last_scanned_at' => now(),
                    ]
                );
                
                // Update the SEO score in the vitrin model
                $vitrin->update(['seo_score' => isset($data['score']) ? $data['score'] : 0]);
                
                $count++;
                $this->info("Analyzed profile: {$vitrin->title} - Score: " . (isset($data['score']) ? $data['score'] : 0));
            }
        } catch (\Exception $e) {
            $this->error("Error analyzing {$vitrin->title}: {$e->getMessage()}");
            
            // Create a failed report
            SeoReport::updateOrCreate(
                ['vitrin_id' => $vitrin->id],
                [
                    'user_id' => $vitrin->user_id,
                    'url' => "https://{$vitrin->subdomain}.hekimport.com",
                    'status' => 'failed',
                    'last_scanned_at' => now(),
                ]
            );
        }
    }
    
    $this->info("Completed SEO analysis for {$count} profiles.");
})->purpose('Generate SEO reports for all active profiles');
