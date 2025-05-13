<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the forum_categories table exists
        if (!Schema::hasTable('forum_categories')) {
            $this->command->info('Table forum_categories does not exist. Skipping seeder.');
            return;
        }
        
        // Add dental-specific categories
        $categories = [
            [
                'name' => 'DUS Sınavı',
                'slug' => 'dus-sinavi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ders Notları',
                'slug' => 'ders-notlari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Klinik Vakalar',
                'slug' => 'klinik-vakalar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Akademik Tartışmalar',
                'slug' => 'akademik-tartismalar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muayenehane Yönetimi',
                'slug' => 'muayenehane-yonetimi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teknoloji ve Ekipmanlar',
                'slug' => 'teknoloji-ve-ekipmanlar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Genel Konular',
                'slug' => 'genel-konular',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert categories and log results
        foreach ($categories as $category) {
            // Skip if the category already exists
            if (DB::table('forum_categories')->where('slug', $category['slug'])->exists()) {
                $this->command->info("Category '{$category['name']}' already exists. Skipping.");
                continue;
            }
            
            DB::table('forum_categories')->insert($category);
            $this->command->info("Added forum category: {$category['name']}");
        }
    }
}
