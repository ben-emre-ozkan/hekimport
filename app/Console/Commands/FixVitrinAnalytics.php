<?php

namespace App\Console\Commands;

use App\Models\ProfileVisit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixVitrinAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vitrin:fix-analytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix and diagnose vitrin analytics issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting vitrin analytics diagnostic...');
        
        // Check for the visitor_id issue
        $this->checkVisitorIdColumn();
        
        // Check all required tables exist
        $this->checkRequiredTables();
        
        // Create test data if needed
        if ($this->confirm('Would you like to create some test data?')) {
            $this->createTestData();
        }
        
        $this->info('Diagnostics completed.');
    }
    
    /**
     * Check for the visitor_id vs ip_address issue
     */
    protected function checkVisitorIdColumn()
    {
        $this->info('Checking for visitor_id issue in ProfileVisit model...');
        
        // Check if profile_visits table has visitor_id column
        if (Schema::hasColumn('profile_visits', 'visitor_id')) {
            $this->info('visitor_id column exists in profile_visits table. This is inconsistent with the application code.');
            
            if ($this->confirm('Would you like to add visitor_id column to match the application code?')) {
                // Add column if needed
                Schema::table('profile_visits', function ($table) {
                    $table->string('visitor_id')->nullable()->after('ip_address');
                });
                
                // Copy data from ip_address to visitor_id
                DB::statement('UPDATE profile_visits SET visitor_id = ip_address WHERE visitor_id IS NULL');
                
                $this->info('visitor_id column added and populated from ip_address.');
            }
        } else {
            $this->info('visitor_id column does not exist in profile_visits table.');
            $this->info('The VitrinAnalyticsDashboard component has been updated to use ip_address instead.');
        }
    }
    
    /**
     * Check that all required tables exist
     */
    protected function checkRequiredTables()
    {
        $requiredTables = [
            'profile_visits',
            'vitrin_analytics',
            'vitrins',
        ];
        
        $this->info('Checking required tables...');
        
        foreach ($requiredTables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("✓ {$table} table exists");
                
                // Count records
                $count = DB::table($table)->count();
                $this->info("  - {$count} records found");
            } else {
                $this->error("✗ {$table} table does not exist");
            }
        }
    }
    
    /**
     * Create test data for development/testing
     */
    protected function createTestData()
    {
        $this->info('Creating test data...');
        
        // Check if we have any vitrins
        $vitrinCount = DB::table('vitrins')->count();
        
        if ($vitrinCount === 0) {
            $this->error('No vitrins found. Please create a vitrin first.');
            return;
        }
        
        // Get first vitrin ID
        $vitrinId = DB::table('vitrins')->first()->id;
        
        // Create profile visits
        $visitCount = $this->ask('How many profile visits would you like to create?', 50);
        
        $this->info("Creating {$visitCount} profile visits for vitrin ID {$vitrinId}...");
        
        $ips = [
            '192.168.1.1',
            '192.168.1.2',
            '192.168.1.3',
            '192.168.1.4',
            '192.168.1.5',
        ];
        
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (iPad; CPU OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15',
        ];
        
        for ($i = 0; $i < $visitCount; $i++) {
            // Randomly select an IP and agent
            $ip = $ips[array_rand($ips)];
            $agent = $agents[array_rand($agents)];
            
            // Create a visit in the last 30 days
            $date = now()->subDays(rand(0, 30))->subHours(rand(0, 23));
            
            ProfileVisit::create([
                'vitrin_id' => $vitrinId,
                'ip_address' => $ip,
                'user_agent' => $agent,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        
        $this->info('Profile visits created successfully.');
    }
} 