<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // We don't need to create the table again if it already exists
        if (!Schema::hasTable('forum_categories')) {
            return;
        }

        // Add dental-specific categories - match the actual table structure
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

        // Insert categories into the database
        DB::table('forum_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't delete the table, just remove the specific categories we added
        if (Schema::hasTable('forum_categories')) {
            $categoryNames = [
                'DUS Sınavı',
                'Ders Notları',
                'Klinik Vakalar',
                'Akademik Tartışmalar',
                'Muayenehane Yönetimi',
                'Teknoloji ve Ekipmanlar',
                'Genel Konular',
            ];
            
            DB::table('forum_categories')->whereIn('name', $categoryNames)->delete();
        }
    }
};
