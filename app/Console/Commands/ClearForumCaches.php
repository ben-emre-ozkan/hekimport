<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClearForumCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum:clear-cache {--all : Clear all related caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear forum-related caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        
        $this->info('Clearing forum caches...');
        
        // Clear forum statistics caches
        Cache::forget('forum_stats');
        $this->info('✓ Forum statistics cache cleared');
        
        // Clear forum active users cache
        Cache::forget('forum_active_users');
        $this->info('✓ Forum active users cache cleared');
        
        // Clear forum latest activities cache
        Cache::forget('forum_latest_activities');
        $this->info('✓ Latest activities cache cleared');
        
        if ($this->option('all')) {
            // Clear all topic-related caches
            $this->info('Clearing all topic and category caches...');
            
            // Get all topic IDs
            $topicIds = DB::table('forum_topics')->pluck('id');
            $count = 0;
            
            // Clear topic caches
            foreach ($topicIds as $topicId) {
                Cache::forget("forum_topic_{$topicId}");
                
                // Clear message caches for each page
                for ($page = 1; $page <= 10; $page++) {
                    Cache::forget("forum_messages_{$topicId}_page_{$page}");
                }
                $count++;
            }
            
            $this->info("✓ Cleared caches for {$count} topics");
            
            // Pattern-based cache clearing for categories and filtered topics
            $keys = collect(Cache::getPrefix().'forum_categories_*', Cache::getPrefix().'forum_topics_*');
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            
            $this->info('✓ Cleared all category and topic list caches');
        }
        
        $totalTime = round((microtime(true) - $startTime) * 1000, 2);
        $this->info("Cache clearing completed in {$totalTime}ms");
        
        return 0;
    }
} 