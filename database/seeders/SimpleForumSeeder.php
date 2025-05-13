<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SimpleForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info("Starting simplified forum content seeding...");

        // Get all dentist users
        $dentists = User::whereHas('roles', function($q) {
            $q->where('name', 'dentist');
        })->get();

        if ($dentists->isEmpty()) {
            $this->command->error("No dentist users found. Please run DummyDentistsSeeder first.");
            return;
        }

        // Get all forum categories
        $categories = ForumCategory::all();

        if ($categories->isEmpty()) {
            $this->command->error("No forum categories found. Please run ForumCategorySeeder first.");
            return;
        }

        DB::beginTransaction();

        try {
            // Clear existing forum data
            $this->command->info("Clearing existing forum data...");
            ForumMessage::truncate();
            ForumTopic::truncate();
            
            // Create a few sample topics
            $categoryData = [
                "DUS Sınavı" => [
                    [
                        "title" => "DUS 2023 Sonuçları Açıklandı",
                        "content" => "DUS 2023 sonuçları açıklandı. Herkes tercihlerini ve puanlarını paylaşabilir mi? Hangi puanla hangi bölümlere girildi?",
                        "replies" => [
                            "Ben 87.5 ile Ortodonti kazandım, İstanbul Üniversitesi.",
                            "Ankara Üniversitesi Endodonti için 84.2 gerekiyormuş, ben 85.3 ile girdim.",
                            "Bu yıl puanlar biraz yüksekti sanki. Ben 82.1 ile Periodontoloji kazandım."
                        ]
                    ]
                ],
                "Klinik Vakalar" => [
                    [
                        "title" => "Komplike Kök Kanal Tedavisi Vakası",
                        "content" => "Geçen hafta karşılaştığım ilginç bir vaka: 46 yaşında erkek hasta, alt sağ 1. molar dişinde şiddetli ağrı şikayetiyle başvurdu. Radyografide C-şekilli kanal anatomisi gözlendi ve kalsifikasyon mevcuttu. Nasıl bir tedavi yaklaşımı önerirsiniz?",
                        "replies" => [
                            "C-şekilli kanallarda ultrasonik uçlar çok yardımcı oluyor, ben mutlaka kullanıyorum.",
                            "Kalsifikasyon durumunda CBCT almayı düşündünüz mü? Kanal yapısını daha net gösterir.",
                            "Ben benzer bir vakada öncelikle koronal giriş kavitesini biraz daha geniş tutarak başladım."
                        ]
                    ]
                ],
                "Muayenehane Yönetimi" => [
                    [
                        "title" => "Dijital Hasta Takip Sistemleri",
                        "content" => "Muayenehanemde dijital hasta takip sistemine geçmek istiyorum. Kullandığınız yazılımlardan memnun musunuz? Önerileriniz nelerdir?",
                        "replies" => [
                            "Ben üç yıldır DentAssist kullanıyorum ve oldukça memnunum. Randevu takibi ve hasta hatırlatmaları çok işe yarıyor.",
                            "Bulut tabanlı sistemler veri güvenliği açısından endişe yaratabilir. Ben lokal sunucu kullanan bir yazılımı tercih ettim.",
                            "Mutlaka dijital radyografi entegrasyonu olan bir sistem seçin. Sonradan entegre etmek sorun olabiliyor."
                        ]
                    ]
                ]
            ];

            foreach ($categoryData as $categoryName => $topics) {
                $category = $categories->where('name', $categoryName)->first();
                
                if (!$category) {
                    $this->command->warn("Category '$categoryName' not found, skipping...");
                    continue;
                }

                foreach ($topics as $topicData) {
                    // Select a random dentist as the topic creator
                    $topicCreator = $dentists->random();
                    
                    // Create topic
                    $topic = ForumTopic::create([
                        "category_id" => $category->id,
                        "user_id" => $topicCreator->id,
                        "title" => $topicData["title"],
                        "slug" => Str::slug($topicData["title"]),
                        "is_pinned" => false,
                        "created_at" => Carbon::now()->subDays(rand(1, 7)),
                        "updated_at" => Carbon::now()->subDays(rand(0, 2)),
                    ]);

                    // Create initial message
                    ForumMessage::create([
                        "topic_id" => $topic->id,
                        "user_id" => $topicCreator->id,
                        "content" => $topicData["content"],
                        "created_at" => $topic->created_at,
                        "updated_at" => $topic->created_at,
                    ]);

                    // Generate responses
                    $respondents = $dentists->filter(fn($d) => $d->id != $topicCreator->id)
                        ->shuffle()
                        ->take(count($topicData["replies"]))
                        ->values();
                    
                    $messageTime = $topic->created_at;

                    foreach ($topicData["replies"] as $index => $reply) {
                        $messageTime = (clone $messageTime)->addHours(rand(2, 24));
                        
                        ForumMessage::create([
                            "topic_id" => $topic->id,
                            "user_id" => $respondents[$index]->id,
                            "content" => $reply,
                            "created_at" => $messageTime,
                            "updated_at" => $messageTime,
                        ]);
                    }

                    $this->command->info("Created topic: {$topicData["title"]} with " . (count($topicData["replies"]) + 1) . " messages");
                }
            }

            DB::commit();
            $this->command->info("Forum content has been successfully seeded.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error seeding forum content: " . $e->getMessage());
            throw $e;
        }
    }
} 