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

class ForumContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting forum content seeding...');

        // Get all dentist users
        $dentists = User::whereHas('roles', function($q) {
            $q->where('name', 'dentist');
        })->get();

        if ($dentists->isEmpty()) {
            $this->command->error('No dentist users found. Please run DummyDentistsSeeder first.');
            return;
        }

        // Get all forum categories
        $categories = ForumCategory::all();

        if ($categories->isEmpty()) {
            $this->command->error('No forum categories found. Please run ForumCategorySeeder first.');
            return;
        }

        // Map specialized topics to appropriate categories
        $topicsByCategory = [
            'DUS Sınavı' => [
                [
                    'title' => 'DUS 2023 Sonuçları Açıklandı',
                    'content' => 'DUS 2023 sonuçları açıklandı. Herkes tercihlerini ve puanlarını paylaşabilir mi? Hangi puanla hangi bölümlere girildi? Deneyimlerinizi paylaşırsanız çok sevinirim.',
                    'responses' => [
                        'Ben 87.5 ile Ortodonti kazandım, İstanbul Üniversitesi.',
                        'Ankara Üniversitesi Endodonti için 84.2 gerekiyormuş, ben 85.3 ile girdim.',
                        'Bu yıl puanlar biraz yüksekti sanki. Ben 82.1 ile Periodontoloji kazandım.',
                        'Cerrahide minimum 86 ile alan oldu diye duydum, doğru mu?',
                        "Evet, ben 86.4 ile Ağız, Diş ve Çene Cerrahisi'ni kazandım.",
                    ]
                ],
                [
                    'title' => 'DUS Hazırlık İçin Tavsiyeler',
                    'content' => 'Arkadaşlar, DUS için hazırlanmaya yeni başladım. Önerdiğiniz kaynaklar, çalışma programları var mı? Hangi konulara ağırlık vermeliyim?',
                    'responses' => [
                        'Kesinlikle Temel Bilimler önemli. Ben Anatomi ve Fizyoloji için şu kitapları öneririm: [kitap listesi]',
                        'Çalışma programını düzenli tutmak önemli. Ben günde 6-8 saat çalışıyordum, hafta sonları da dahil.',
                        'Soru bankası çözmek çok faydalı oldu benim için. Özellikle son 10 yılın çıkmış sorularını muhakkak çözün.',
                        'Ben bir çalışma grubu kurmuştum, beraber çalışmak motivasyonu yüksek tutuyor.',
                        'Anatomi ve Fizyoloji en çok puan getiren derslerdi benim için. Ağırlık vermenizi öneririm.',
                    ]
                ],
            ],
            'Ders Notları' => [
                [
                    'title' => 'Ortodonti Ders Notlarımı Paylaşıyorum',
                    'content' => 'Hocalarımın en son anlattığı konulara göre hazırladığım ortodonti notlarımı paylaşmak istedim. Özellikle iskeletsel anomaliler ve tedavileri konusunda detaylı bilgiler var.',
                    'responses' => [
                        'Çok teşekkürler, gerçekten çok detaylı ve anlaşılır notlar olmuş.',
                        'Ben de geçen dönemki endodonti notlarımı paylaşabilirim eğer isteyen olursa.',
                        'Class II malokluzyonlarla ilgili kısım özellikle çok yardımcı oldu, sağolun.',
                        'Acaba iskeletsel ankraj sistemleriyle ilgili notlarınız var mı?',
                        "Hocam harika olmuş. Ben sadece bir düzeltme yapmak istiyorum: Sayfa 24'te mandibular retrognati tedavisinde..",
                    ]
                ],
                [
                    'title' => 'Periodontoloji Klinik Vaka Notları',
                    'content' => 'Son dönem klinik stajlarımda tuttuğum periodontoloji vaka notlarını paylaşmak istedim. İleri periodontal hastalık teşhis ve tedavi yaklaşımları var.',
                    'responses' => [
                        'Özellikle furkasyon defektleriyle ilgili kısım çok yararlı olmuş, teşekkürler.',
                        'Regeneratif tedavilerle ilgili güncel yaklaşımlar da eklenmiş, çok iyi olmuş.',
                        'Ben de önümüzdeki hafta periodontal cerrahi rotasyonuna başlayacağım, tam zamanında geldi.',
                        'Vaka fotoğrafları eklerseniz daha anlaşılır olabilir belki?',
                        'Guided tissue regeneration konusundaki güncel uygulamaların yer alması çok iyi olmuş.',
                    ]
                ],
            ],
            'Klinik Vakalar' => [
                [
                    'title' => 'Komplike Kök Kanal Tedavisi Vakası',
                    'content' => 'Geçen hafta karşılaştığım ilginç bir vaka: 46 yaşında erkek hasta, alt sağ 1. molar dişinde şiddetli ağrı şikayetiyle başvurdu. Radyografide C-şekilli kanal anatomisi gözlendi ve kalsifikasyon mevcuttu. Nasıl bir tedavi yaklaşımı önerirsiniz?',
                    'responses' => [
                        'C-şekilli kanallarda ultrasonik uçlar çok yardımcı oluyor, ben mutlaka kullanıyorum.',
                        'Kalsifikasyon durumunda CBCT almayı düşündünüz mü? Kanal yapısını daha net gösterir.',
                        'Ben benzer bir vakada öncelikle koronal giriş kavitesini biraz daha geniş tutarak başladım ve mikroskop kullandım.',
                        'Retreatment vakaları için özel olarak hazırlanmış nikel titanyum eğeler işinizi kolaylaştırabilir.',
                        'Irrigasyon protokolü olarak ne kullanıyorsunuz? Ben EDTA ve NaOCl kombinasyonunun oldukça etkili olduğunu düşünüyorum.',
                    ]
                ],
                [
                    'title' => 'Mandibular Fraktür Vakası - Tedavi Yaklaşımı',
                    'content' => 'Trafik kazası sonrası acile gelen 34 yaşında erkek hastada bilateral mandibular corpus fraktürü tespit edildi. CBCT görüntülerini paylaşıyorum. Tedavi planlaması ve cerrahi yaklaşım için önerilerinizi almak isterim.',
                    'responses' => [
                        'Öncelikle intrakapsüler kırık olup olmadığını değerlendirmek önemli. Görüntülerde kondil başı sağlam görünüyor.',
                        'Bu vakada 2.0 mm mini plak sistemlerinin kullanılması uygun olacaktır diye düşünüyorum.',
                        'Postoperatif dönemde intermaksiller fiksasyon süresi ne kadar olmalı tartışılabilir.',
                        'Dişleri olduğu için arklar kullanılabilir, ancak elastik traksiyonların yeterli olacağını düşünüyorum.',
                        'Açık redüksiyon ve internal fiksasyon kaçınılmaz görünüyor. Ekstraoral yaklaşım tercih edilebilir.',
                    ]
                ],
            ],
            'Akademik Tartışmalar' => [
                [
                    'title' => 'Kompozit vs Amalgam - Güncel Yaklaşımlar',
                    'content' => 'Posterior restorasyonlarda kompozit ve amalgam kullanımı hakkında güncel yaklaşımlar nelerdir? Amalgam kullanımı azalıyor mu? Hem klinik performans hem de toksikolojik açıdan değerlendirmelerinizi merak ediyorum.',
                    'responses' => [
                        'Son 10 yıldır pratiğimde neredeyse hiç amalgam kullanmıyorum. Modern kompozitler posterior bölgede de oldukça başarılı.',
                        'Amalgam halen en dayanıklı restoratif materyal. Ancak hastalar estetik sebeplerle kompozit talep ediyorlar genellikle.',
                        'Amalgamın çevresel etkileri büyük bir sorun. Bazı ülkeler tamamen yasakladı bile.',
                        'Bulk-fill kompozitler posterior restorasyonlarda hem zamandan kazandırıyor hem de oldukça dayanıklı.',
                        'Amalgam toksikolojisi üzerine yapılan çalışmaların çoğu düşük dozda maruziyetin anlamlı sağlık riskleri oluşturmadığını gösteriyor aslında.',
                    ]
                ],
                [
                    'title' => 'İmplant Yüzey Teknolojilerindeki Yeni Gelişmeler',
                    'content' => 'İmplant yüzey teknolojilerindeki son gelişmeler neler? Hangi yüzey özellikleri osseointegrasyonu daha iyi sağlıyor? Klinik deneyimleriniz neler?',
                    'responses' => [
                        'SLA yüzeyli implantların osseointegrasyonu %30 daha hızlı olduğuna dair çalışmalar var.',
                        'Nanoteknoloji destekli implant yüzeyleri hidrofilik özellikleri artırarak erken iyileşmeyi olumlu etkiliyor.',
                        'Lazerle modifiye edilmiş yüzeyler düzenli mikro porözite sağlıyor ve osteoblast adhezyonunu artırıyor.',
                        'Antibakteriyel özellikli implant yüzeyleri üzerine yeni çalışmalar var. Özellikle gümüş nanopartiküllerle kaplanmış implantlar periimplantitis riskini azaltabilir.',
                        'Yüzey teknolojilerinden bağımsız olarak implant makro tasarımının da (thread design, etc.) osseointegrasyonda önemli olduğunu unutmamak lazım.',
                    ]
                ],
            ],
            'Muayenehane Yönetimi' => [
                [
                    'title' => 'Dijital Hasta Takip Sistemleri',
                    'content' => 'Muayenehanemde dijital hasta takip sistemine geçmek istiyorum. Kullandığınız yazılımlardan memnun musunuz? Önerileriniz nelerdir?',
                    'responses' => [
                        'Ben üç yıldır DentAssist kullanıyorum ve oldukça memnunum. Randevu takibi ve hasta hatırlatmaları çok işe yarıyor.',
                        'Bulut tabanlı sistemler veri güvenliği açısından endişe yaratabilir. Ben lokal sunucu kullanan bir yazılımı tercih ettim.',
                        'Mutlaka dijital radyografi entegrasyonu olan bir sistem seçin. Sonradan entegre etmek sorun olabiliyor.',
                        'Hasta iletişimi ve pazarlama özellikleri olan bir yazılım tercih etmek faydalı olabilir. SMS/email hatırlatmaları hasta devamlılığını artırıyor.',
                        'Kurarken ilk maliyeti yüksek olabilir ama uzun vadede kağıt, arşivleme ve personel zamanu açısından çok tasarruf sağlıyor.',
                    ]
                ],
                [
                    'title' => 'Muayenehanede Maliyet Yönetimi ve Karlılık',
                    'content' => 'Maliyetlerin arttığı bu dönemde muayenehane karlılığını korumak için neler yapıyorsunuz? Hangi alanlarda tasarruf sağlanabilir?',
                    'responses' => [
                        'Sarf malzemelerinde toplu alım yaparak önemli indirimler sağlıyorum. Özellikle pahalı malzemelerde stok kontrolü çok önemli.',
                        'Enerji tasarrufu için LED aydınlatmaya geçtik ve klima sistemlerini yeniledik. Faturalarda ciddi düşüş oldu.',
                        'Tek kullanımlık malzemeler yerine otoklav edilebilir olanları tercih etmek uzun vadede tasarruf sağlıyor.',
                        'Personel verimliliğini artırmak için görev dağılımını optimize ettik. Herkesin net görev tanımı var.',
                        'Benim için en etkili yöntem tedavi planlamalarını iyileştirmek oldu. Multidisipliner vakalarda doğru planlama yaparak tekrar tedavileri azalttım.',
                    ]
                ],
            ],
            'Teknoloji ve Ekipmanlar' => [
                [
                    'title' => 'CAD/CAM Sistemleri Deneyimleriniz',
                    'content' => 'Muayenehaneme CAD/CAM sistemi almayı düşünüyorum. Kullandığınız sistemlerden memnun musunuz? Hangi markayı önerirsiniz? ROI süresi ne kadar?',
                    'responses' => [
                        'Ben 3 yıldır CEREC sistemi kullanıyorum ve oldukça memnunum. İlk yatırım maliyetini yaklaşık 1.5 yılda çıkardım.',
                        'Malzeme masrafları yüksek olabiliyor, bunu hesaba katmak lazım. Ancak hastalar tek seansta tamamlanan tedavileri tercih ediyor.',
                        'Ben Planmeca kullanıyorum ve memnunum. Öğrenme süreci biraz uzun olabiliyor, eğitim desteği alın mutlaka.',
                        'Yeni başlayanlar için kiralama seçenekleri de değerlendirilebilir. Böylece büyük bir yatırım yapmadan deneyimleyebilirsiniz.',
                        'Freze ünitesinin bakım maliyetlerini de hesaba katın. Yıllık servis anlaşması yapmanızı öneririm.',
                    ]
                ],
                [
                    'title' => 'Hangi Endodontik Motor?',
                    'content' => 'Yeni bir endodontik motor almayı düşünüyorum. Kablosuz olanları tercih edenler memnun mu? Hangi markaları önerirsiniz?',
                    'responses' => [
                        'X-Smart Plus kullanıyorum, pil ömrü gayet iyi ve hafif olması büyük avantaj.',
                        'Kablosuz sistemler hareket serbestliği açısından çok avantajlı, kesinlikle tavsiye ederim.',
                        'Ben Reciproc ile çalışıyorum ve oldukça memnunum. Hem reciprocating hem de rotasyon modu var.',
                        "E-connect Pro'yu öneririm. Hem apex locator entegrasyonu var hem de kullanımı oldukça kolay.",
                        'Ucuz motorlar eğe kırılmalarına neden olabiliyor. Kaliteli bir marka tercih etmek uzun vadede daha ekonomik.',
                    ]
                ],
            ],
            'Genel Konular' => [
                [
                    'title' => 'Diş Hekimliğinde Kariyer Gelişimi',
                    'content' => 'Meslektaşlarım, kariyerinizde hangi adımları attınız? Uzmanlık, akademi veya özel klinik deneyimlerinizi paylaşır mısınız? Mesleğe yeni başlayan biri için önerileriniz neler olur?',
                    'responses' => [
                        'Mezun olduktan sonra 2 yıl bir klinikte çalıştım, ardından DUS ile uzmanlık yaptım. Şimdi kendi muayenehanem var.',
                        'Ben direkt kendi muayenehanemi açtım ama keşke önce bir süre deneyim kazansaydım. İlk yıl çok zorlandım.',
                        'Akademisyenlik bana daha uygun geldi. Hem klinik yapıyorum hem de araştırma. Her ikisini de seviyorsanız tavsiye ederim.',
                        'İlk yıllarda mümkün olduğunca çok kurs ve kongre katılmanızı öneririm. Networking çok önemli.',
                        'Ben 5 yıl kurumsal bir klinikte çalıştıktan sonra kendi yerimi açtım. Bu süreçte hem klinik deneyim hem de hasta portföyü oluşturdum.',
                    ]
                ],
                [
                    'title' => 'COVID-19 Sonrası Diş Hekimliği Pratiği',
                    'content' => 'Pandemi sonrası klinik pratiklerimizde neleri kalıcı olarak değiştirmek zorunda kaldık? Hasta sayıları eski seviyeye döndü mü? Enfeksiyon kontrol protokollerinizde değişiklikler yapmak zorunda kaldınız mı?',
                    'responses' => [
                        'Randevular arasında daha fazla süre bırakıyorum hala. Hasta sayım pandemi öncesine göre %15 civarı daha az.',
                        'Havalandırma sistemimizi tamamen yeniledik. HEPA filtreler ekledik ve UV sterilizasyon sistemleri kurduk.',
                        'Hasta bekleme alanını yeniden düzenledik. Artık daha az kişi aynı anda bekliyor ve sosyal mesafeyi koruyoruz.',
                        'Hastaların çoğu hala ilk girişte ateş ölçümü ve dezenfektan uygulaması bekliyor. Bu protokolü devam ettiriyoruz.',
                        'Kişisel koruyucu ekipman kullanımı (N95, yüz siperi vs.) bazı işlemlerde kalıcı hale geldi diyebilirim.',
                    ]
                ],
            ],
        ];

        DB::beginTransaction();

        try {
            // Create topics for each category with responses from various dentists
            foreach ($topicsByCategory as $categoryName => $topics) {
                $category = $categories->where('name', $categoryName)->first();
                
                if (!$category) {
                    $this->command->warn("Category '$categoryName' not found, skipping...");
                    continue;
                }

                foreach ($topics as $topicData) {
                    // Randomly select a dentist as the topic creator
                    $topicCreator = $dentists->random();
                    
                    // Create the topic
                    $topic = ForumTopic::create([
                        'category_id' => $category->id,
                        'user_id' => $topicCreator->id,
                        'title' => $topicData['title'],
                        'slug' => Str::slug($topicData['title']),
                        'is_pinned' => false,
                        'created_at' => Carbon::now()->subDays(rand(1, 30)),
                        'updated_at' => Carbon::now()->subDays(rand(0, 5)),
                    ]);

                    // Create the initial message by the topic creator
                    ForumMessage::create([
                        'topic_id' => $topic->id,
                        'user_id' => $topicCreator->id,
                        'content' => $topicData['content'],
                        'created_at' => $topic->created_at,
                        'updated_at' => $topic->created_at,
                    ]);

                    // Create responses from other dentists
                    // Skip first dentist (creator) to avoid replying to themselves
                    $availableDentists = $dentists->shuffle()
                        ->filter(fn($d) => $d->id !== $topicCreator->id)
                        ->values();

                    $lastMessageTime = $topic->created_at;

                    foreach ($topicData['responses'] as $index => $responseContent) {
                        $respondent = $availableDentists[$index % $availableDentists->count()];
                        
                        // Each response happens 1-24 hours after the previous message
                        $lastMessageTime = (clone $lastMessageTime)->addHours(rand(1, 24));
                        
                        ForumMessage::create([
                            'topic_id' => $topic->id,
                            'user_id' => $respondent->id,
                            'content' => $responseContent,
                            'created_at' => $lastMessageTime,
                            'updated_at' => $lastMessageTime,
                        ]);
                    }

                    $this->command->info("Created topic: {$topicData['title']} with " . (count($topicData['responses']) + 1) . " messages");
                }
            }

            DB::commit();
            $this->command->info('Forum content has been successfully seeded.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding forum content: ' . $e->getMessage());
            throw $e;
        }
    }
} 