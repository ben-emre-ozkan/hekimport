<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample categories if none exist
        if (ForumCategory::count() === 0) {
            $categories = [
                ['name' => 'DUS Sınavı', 'slug' => 'dus-sinavi'],
                ['name' => 'Klinik Vakalar', 'slug' => 'klinik-vakalar'],
                ['name' => 'Muayenehane Yönetimi', 'slug' => 'muayenehane-yonetimi'],
                ['name' => 'Mesleki Gelişim', 'slug' => 'mesleki-gelisim'],
                ['name' => 'Genel Konular', 'slug' => 'genel-konular'],
                ['name' => 'Akademik Tartışmalar', 'slug' => 'akademik-tartismalar'],
                ['name' => 'Ders Notları', 'slug' => 'ders-notlari'],
                ['name' => 'Teknoloji ve Ekipmanlar', 'slug' => 'teknoloji-ve-ekipmanlar'],
            ];

            foreach ($categories as $category) {
                ForumCategory::create($category);
            }
        }

        // Find dentist and admin users to use as topic creators
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['dentist', 'admin']);
        })->take(5)->get();

        if ($users->isEmpty()) {
            $this->command->info('No dentist or admin users found. Sample topics will not be created.');
            return;
        }

        // Create sample topics if there are fewer than 25
        if (ForumTopic::count() < 25) {
            $categories = ForumCategory::all();
            
            $sampleTopics = [
                [
                    'title' => 'DUS 2023 Hazırlık Stratejileri',
                    'category' => 'DUS Sınavı',
                    'content' => 'Merhaba meslektaşlarım, önümüzdeki DUS sınavına hazırlanıyorum. Hangi kaynakları kullanıyorsunuz ve nasıl bir çalışma planı önerirsiniz?',
                ],
                [
                    'title' => 'Zor Kanal Tedavisi Vakası',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Bugün kliniğimde karşılaştığım ilginç bir kanal tedavisi vakasını paylaşmak istiyorum. Alt 1. molar dişte C şeklinde kanal konfigürasyonu vardı...',
                    'is_pinned' => true,
                ],
                [
                    'title' => 'Muayenehane İçin Dijital Randevu Sistemi Önerileri',
                    'category' => 'Muayenehane Yönetimi',
                    'content' => 'Yeni açtığım muayenehanem için iyi bir dijital randevu sistemi arıyorum. Kullandığınız sistemler hakkında deneyimlerinizi paylaşır mısınız?',
                ],
                [
                    'title' => 'İmplant Eğitimi Tavsiyesi',
                    'category' => 'Mesleki Gelişim', 
                    'content' => 'İmplant üzerine kendimi geliştirmek istiyorum. Tavsiye edebileceğiniz kurs veya eğitim programları var mı?',
                ],
                [
                    'title' => 'Hekimport Hakkında Görüşler',
                    'category' => 'Genel Konular',
                    'content' => 'Hekimport platformunu ne zamandır kullanıyorsunuz? Size ne gibi faydaları oldu?',
                ],
                [
                    'title' => 'Ortodonti Vaka Konsültasyonu',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Şu anda tedavi ettiğim bir hastamın vaka fotoğraflarını paylaşmak ve görüşlerinizi almak istiyorum. Sınıf II divizyon 1 maloklüzyon...',
                ],
                [
                    'title' => 'SGK Fatura İşlemleri',
                    'category' => 'Muayenehane Yönetimi',
                    'content' => 'SGK fatura işlemlerinde yaşadığım sorunları çözmek için önerileriniz var mı? Özellikle reddedilen işlemler konusunda...',
                ],
                [
                    'title' => 'COVID-19 Sonrası Klinik Düzenlemeleri',
                    'category' => 'Muayenehane Yönetimi',
                    'content' => 'Pandemi sonrası kliniğinizde ne gibi kalıcı düzenlemeler yaptınız? Havalandırma sistemleri, bekleme odası düzeni vb. konularda deneyimlerinizi paylaşabilir misiniz?',
                    'is_pinned' => true,
                ],
                [
                    'title' => 'Diş Hekimliği Öğrencileri İçin Tavsiyeler',
                    'category' => 'Genel Konular',
                    'content' => 'Diş hekimliği fakültesinde okuyan öğrenciler için tecrübeli hekimler olarak neler tavsiye edersiniz? Mesleğe başlamadan önce bilinmesi gerekenler nelerdir?',
                ],
                [
                    'title' => 'Estetik Dolgu Teknikleri',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Anterior bölgede estetik kompozit restorasyonları yaparken kullandığınız teknikler ve materyal tercihleri nelerdir?',
                ],
                [
                    'title' => '2025 DUS SINAV SONUÇLARI',
                    'category' => 'DUS Sınavı',
                    'content' => 'Sabah açıklanmış 76\'yla ÇAPA\'ya atandım ho ailırım.',
                    'is_pinned' => true,
                ],
                [
                    'title' => 'Endodontik Tedavide Yeni Teknolojiler',
                    'category' => 'Teknoloji ve Ekipmanlar',
                    'content' => 'Son dönemde endodontik tedavilerde kullanılan yeni teknolojik ekipmanlar hakkında bilgi paylaşımı yapalım. Özellikle reciproc sistemleri ve ısıl işlem görmüş nikel titanyum eğeler konusunda deneyimleriniz nelerdir?',
                ],
                [
                    'title' => 'Pedodontide Davranış Yönetimi',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Çocuk hastalarda davranış yönetimi konusunda zorlanıyorum. Özellikle 3-5 yaş arası çocuklarda başarılı olduğunuz teknikleri paylaşabilir misiniz?',
                ],
                [
                    'title' => 'Periodontoloji Uzmanlık Deneyimleri',
                    'category' => 'Akademik Tartışmalar',
                    'content' => 'Periodontoloji uzmanlığı düşünüyorum. Bu alanda uzmanlaşmış hekimlerden alan hakkında bilgi alabilir miyim? İş imkanları, klinik pratik ve akademik çalışma alanları nasıl?',
                ],
                [
                    'title' => 'İmplant Uygulamalarında Komplikasyonlar',
                    'category' => 'Klinik Vakalar',
                    'content' => 'İmplant cerrahisinde karşılaştığınız komplikasyonları ve çözüm yöntemlerinizi paylaşır mısınız? Özellikle sinüs perforasyonu ve inferior alveolar sinir hasarı durumlarında neler yapıyorsunuz?',
                ],
                [
                    'title' => 'Oral Patoloji Atlas Önerileri',
                    'category' => 'Ders Notları',
                    'content' => 'Oral patoloji konusunda kapsamlı ve güncel bir atlas arıyorum. Önerileriniz nelerdir? Tercihen Türkçe kaynaklar olursa daha iyi olur.',
                ],
                [
                    'title' => 'Klinikte Dijital Diş Hekimliği Uygulamaları',
                    'category' => 'Teknoloji ve Ekipmanlar',
                    'content' => 'CAD/CAM sistemleri, intraoral tarayıcılar ve 3D yazıcıların klinik pratikte kullanımı hakkında deneyimlerinizi paylaşabilir misiniz? Hangi markaları tercih ediyorsunuz ve neden?',
                ],
                [
                    'title' => 'Muayenehane Açarken Dikkat Edilmesi Gerekenler',
                    'category' => 'Muayenehane Yönetimi',
                    'content' => 'Yakında kendi muayenehanemi açmayı planlıyorum. Bürokratik işlemler, lokasyon seçimi, ekipman tercihi ve personel istihdamı konularında nelere dikkat etmeliyim?',
                ],
                [
                    'title' => 'TME Rahatsızlıklarında Teşhis ve Tedavi',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Temporomandibular eklem rahatsızlıklarında kullandığınız teşhis yöntemleri ve tedavi protokolleri nelerdir? Okluzal splint uygulamaları konusundaki deneyimlerinizi de paylaşırsanız sevinirim.',
                ],
                [
                    'title' => 'Akademik Kariyer İmkanları',
                    'category' => 'Akademik Tartışmalar',
                    'content' => 'Diş hekimliği fakültelerinde akademik kariyer yapmak isteyenler için tavsiyeleriniz nelerdir? Akademik hayata başlamak için en iyi zaman hangisidir?',
                ],
                [
                    'title' => 'Hareketli Protezlerde İmplant Destekli Uygulamalar',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Total ve parsiyel protezlerde implant desteği konusunda klinik deneyimlerinizi paylaşır mısınız? İki implant üstü locator ataçman mı, bar tutuculu sistem mi daha avantajlı?',
                ],
                [
                    'title' => 'Diş Hekimliği Fakültesi Tercih Rehberi',
                    'category' => 'Genel Konular',
                    'content' => 'YKS sonrası diş hekimliği düşünen öğrencilere hangi fakülteleri önerirsiniz? Klinik imkanlar, eğitim kadrosu ve şehir dinamiklerini göz önünde bulundurarak bir değerlendirme yapabilir misiniz?',
                ],
                [
                    'title' => 'Diş Beyazlatma Teknikleri ve Materyalleri',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Ofis tipi ve ev tipi beyazlatma sistemlerinden hangileri daha etkili? Kullandığınız ürünler ve protokoller neler? Hassasiyet yönetimini nasıl sağlıyorsunuz?',
                ],
                [
                    'title' => 'Dental Fotoğrafçılık Ekipman Önerileri',
                    'category' => 'Teknoloji ve Ekipmanlar',
                    'content' => 'Klinik dokümantasyon için iyi bir dental fotoğrafçılık seti kurmak istiyorum. Kamera, makro lens, ring flash ve retraktör seçiminde önerileriniz nelerdir?',
                ],
                [
                    'title' => 'Lokal Anestezi Komplikasyonları',
                    'category' => 'Klinik Vakalar',
                    'content' => 'Lokal anestezi uygulaması sırasında veya sonrasında karşılaştığınız komplikasyonlar ve bunların yönetimi hakkında deneyimlerinizi paylaşır mısınız?',
                ],
            ];

            foreach ($sampleTopics as $topicData) {
                $category = $categories->firstWhere('name', $topicData['category']);
                
                if ($category) {
                    $slug = \Illuminate\Support\Str::slug($topicData['title']);
                    
                    // Skip if this topic slug already exists
                    if (ForumTopic::where('slug', $slug)->exists()) {
                        continue;
                    }
                    
                    $user = $users->random();
                    
                    $topic = ForumTopic::create([
                        'category_id' => $category->id,
                        'user_id' => $user->id,
                        'title' => $topicData['title'],
                        'slug' => $slug,
                        'is_pinned' => $topicData['is_pinned'] ?? false,
                    ]);
                    
                    // Create initial message
                    ForumMessage::create([
                        'topic_id' => $topic->id,
                        'user_id' => $user->id,
                        'content' => $topicData['content'],
                    ]);
                    
                    // Add 1-5 random replies
                    $replyCount = rand(1, 5);
                    
                    for ($i = 0; $i < $replyCount; $i++) {
                        $replyUser = $users->random();
                        
                        $replyContents = [
                            'Bu konuyla ilgili görüşlerimi paylaşmak istiyorum. ' . fake()->paragraph(rand(2, 4)),
                            'Çok güzel bir konu açmışsınız. Ben de benzer deneyimler yaşıyorum. ' . fake()->paragraph(rand(2, 3)),
                            'Teşekkürler paylaşım için! Benim deneyimim biraz farklı oldu. ' . fake()->paragraph(rand(2, 4)),
                            'İlginç bir vaka. Benzer bir durumla ben de karşılaşmıştım. ' . fake()->paragraph(rand(2, 3)),
                            'Bu konuda birkaç makale okumuştum, sizinle paylaşmak isterim. ' . fake()->paragraph(rand(3, 5)),
                            'Katılıyorum, gerçekten önemli bir konu. Benim de eklemek istediklerim var. ' . fake()->paragraph(rand(2, 4)),
                            'Haklısınız, ben de aynı sorunları yaşıyorum. Çözüm için denediğim yöntemler: ' . fake()->paragraph(rand(2, 3)),
                        ];
                        
                        ForumMessage::create([
                            'topic_id' => $topic->id,
                            'user_id' => $replyUser->id,
                            'content' => $replyContents[array_rand($replyContents)],
                        ]);
                    }
                }
            }
        }
    }
} 