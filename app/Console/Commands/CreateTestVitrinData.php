<?php

namespace App\Console\Commands;

use App\Models\ProfileVisit;
use App\Models\User;
use App\Models\Vitrin;
use App\Models\VitrinAnalytic;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTestVitrinData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vitrin:create-test-data
                            {--user_id= : User ID to create test data for}
                            {--vitrin_id= : Vitrin ID to create test data for}
                            {--visits=50 : Number of profile visits to create}
                            {--analytics=100 : Number of analytics events to create}
                            {--days=30 : Number of days to spread the data over}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test data for vitrin analytics and dashboard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test data for vitrin analytics...');
        
        $userId = $this->option('user_id');
        $vitrinId = $this->option('vitrin_id');
        
        // Find or create user if needed
        if (!$userId) {
            $user = User::first();
            if (!$user) {
                $this->error('No users found. Please create a user first or specify a user_id.');
                return 1;
            }
            $userId = $user->id;
        } else {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
        }
        
        // Find or create vitrin
        if (!$vitrinId) {
            $vitrin = Vitrin::where('user_id', $userId)->first();
            if (!$vitrin) {
                $this->info("Creating a new vitrin for user {$userId}...");
                $vitrin = new Vitrin();
                $vitrin->user_id = $userId;
                $vitrin->title = 'Test Vitrin';
                $vitrin->subdomain = 'test-' . uniqid();
                $vitrin->save();
            }
            $vitrinId = $vitrin->id;
        } else {
            $vitrin = Vitrin::find($vitrinId);
            if (!$vitrin) {
                $this->error("Vitrin with ID {$vitrinId} not found.");
                return 1;
            }
        }
        
        $this->info("Using vitrin ID: {$vitrinId}");
        
        // Get command options
        $visitCount = (int)$this->option('visits');
        $analyticsCount = (int)$this->option('analytics');
        $days = (int)$this->option('days');
        
        // Create profile visits
        $this->createProfileVisits($vitrinId, $visitCount, $days);
        
        // Create analytics events
        $this->createAnalyticsEvents($vitrinId, $analyticsCount, $days);
        
        $this->info('Test data created successfully!');
        
        return 0;
    }
    
    /**
     * Create profile visits with varying IPs
     */
    protected function createProfileVisits($vitrinId, $count, $days)
    {
        $this->info("Creating {$count} profile visits...");
        
        $ipAddresses = $this->generateIpAddresses(min($count, 20));
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (iPad; CPU OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36',
        ];
        
        $progressBar = $this->output->createProgressBar($count);
        $progressBar->start();
        
        // Delete existing visits for clean test
        ProfileVisit::where('vitrin_id', $vitrinId)->delete();
        
        for ($i = 0; $i < $count; $i++) {
            // Get random date within time range
            $date = Carbon::now()->subDays(rand(1, $days))->subHours(rand(1, 24));
            
            // Create the visit
            ProfileVisit::create([
                'vitrin_id' => $vitrinId,
                'ip_address' => $ipAddresses[rand(0, count($ipAddresses) - 1)],
                'user_agent' => $userAgents[rand(0, count($userAgents) - 1)],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->line(''); // Add newline after progress bar
    }
    
    /**
     * Create analytics events
     */
    protected function createAnalyticsEvents($vitrinId, $count, $days)
    {
        $this->info("Creating {$count} analytics events...");
        
        $eventTypes = [
            'view', 'bounce', 'call_click', 'email_click', 
            'appointment_request', 'service_view', 'gallery_view',
            'facebook_click', 'instagram_click', 'twitter_click'
        ];
        
        $cities = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya'];
        $regions = ['Marmara', 'İç Anadolu', 'Ege', 'Akdeniz', 'Karadeniz'];
        $deviceTypes = ['mobile', 'desktop', 'tablet'];
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
        ];
        
        $progressBar = $this->output->createProgressBar($count);
        $progressBar->start();
        
        // Delete existing analytics for clean test
        VitrinAnalytic::where('vitrin_id', $vitrinId)->delete();
        
        for ($i = 0; $i < $count; $i++) {
            // Get random date within time range
            $date = Carbon::now()->subDays(rand(1, $days))->subHours(rand(1, 24));
            
            // Get random event type
            $eventType = $eventTypes[rand(0, count($eventTypes) - 1)];
            
            // Create metadata
            $metadata = [
                'city' => $cities[rand(0, count($cities) - 1)],
                'region' => $regions[rand(0, count($regions) - 1)],
                'country' => 'Türkiye',
                'device_type' => $deviceTypes[rand(0, count($deviceTypes) - 1)],
            ];
            
            // Create event data depending on event type
            $eventData = null;
            if ($eventType === 'service_view') {
                $eventData = (string)rand(0, 5); // Service ID
            }
            
            // Add visit duration for some events
            $duration = null;
            if (in_array($eventType, ['view']) && rand(0, 1) === 1) {
                $duration = rand(5, 300); // 5 seconds to 5 minutes
            }
            
            // Create the event
            try {
                VitrinAnalytic::create([
                    'vitrin_id' => $vitrinId,
                    'event_type' => $eventType,
                    'event_data' => $eventData,
                    'metadata' => $metadata,
                    'duration' => $duration,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            } catch (\Exception $e) {
                // If we get an error about missing columns, log it but continue
                $this->error("Error creating analytics event: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->line(''); // Add newline after progress bar
        
        // Create special examples for unique visitor testing
        $this->info("Creating examples for unique visitor testing...");
        
        // Same IP for multiple days
        $sameIp = '192.168.10.1';
        
        for ($i = 0; $i < 3; $i++) {
            $date = Carbon::now()->subDays($i)->startOfDay()->addHours(rand(9, 17));
            
            ProfileVisit::create([
                'vitrin_id' => $vitrinId,
                'ip_address' => $sameIp,
                'user_agent' => $userAgents[rand(0, count($userAgents) - 1)],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        
        $this->info("Created 3 visits with the same IP ($sameIp) on different days for testing");
    }
    
    /**
     * Generate unique IP addresses
     */
    protected function generateIpAddresses($count)
    {
        $ips = [];
        
        for ($i = 0; $i < $count; $i++) {
            $ips[] = rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 254);
        }
        
        return $ips;
    }
}
