<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vitrin;
use App\Models\ProfileVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestVitrinStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:vitrin-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test queries for vitrin analytics to debug issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing ProfileVisit queries...');
        
        // Get a vitrin for testing
        $vitrin = Vitrin::first();
        
        if (!$vitrin) {
            $this->error('No vitrins found to test with');
            return 1;
        }
        
        $this->info("Using vitrin ID: {$vitrin->id}");
        
        // Date range for queries
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $this->info("Date range: {$startDate->toDateTimeString()} to {$endDate->toDateTimeString()}");
        
        // Test the total visits query
        $totalVisits = ProfileVisit::where('vitrin_id', $vitrin->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
            
        $this->info("Total visits: {$totalVisits}");
        
        // Test both query approaches for unique visitors
        try {
            // Approach 1: Using distinct on column name (problematic)
            $uniqueVisitorsQuery1 = ProfileVisit::where('vitrin_id', $vitrin->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->distinct('ip_address')
                ->count('ip_address');
                
            $this->info("Unique visitors (approach 1): {$uniqueVisitorsQuery1}");
        } catch (\Exception $e) {
            $this->error("Error in approach 1: " . $e->getMessage());
        }
        
        try {
            // Approach 2: Using distinct() without parameter (Laravel's standard)
            $uniqueVisitorsQuery2 = ProfileVisit::where('vitrin_id', $vitrin->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select('ip_address')
                ->distinct()
                ->count();
                
            $this->info("Unique visitors (approach 2): {$uniqueVisitorsQuery2}");
        } catch (\Exception $e) {
            $this->error("Error in approach 2: " . $e->getMessage());
        }
        
        // Raw SQL approach
        try {
            $uniqueVisitorsRaw = DB::select("
                SELECT COUNT(DISTINCT ip_address) as count
                FROM profile_visits
                WHERE vitrin_id = ?
                AND created_at BETWEEN ? AND ?
            ", [$vitrin->id, $startDate, $endDate]);
            
            $this->info("Unique visitors (raw SQL): {$uniqueVisitorsRaw[0]->count}");
        } catch (\Exception $e) {
            $this->error("Error in raw SQL: " . $e->getMessage());
        }
        
        return 0;
    }
}
