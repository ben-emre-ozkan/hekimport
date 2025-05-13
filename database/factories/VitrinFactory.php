<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VitrinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vitrin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('tr_TR');
        
        // Common dental specialties in Turkish
        $specialties = [
            'Genel Diş Hekimliği',
            'Ortodonti',
            'Endodonti',
            'Periodontoloji',
            'Ağız, Diş ve Çene Cerrahisi',
            'Protetik Diş Tedavisi',
            'Pedodonti',
            'İmplantoloji',
            'Estetik Diş Hekimliği',
        ];
        
        // Turkish cities
        $cities = [
            'İstanbul',
            'Ankara',
            'İzmir',
            'Bursa',
            'Antalya',
            'Adana',
            'Konya',
            'Gaziantep',
            'Şanlıurfa',
            'Kocaeli',
        ];
        
        // Generate a name from the user's name if available
        $name = '';
        
        // Dental services with Turkish descriptions and prices
        $services = [
            [
                'name' => 'Diş Beyazlatma',
                'description' => 'Profesyonel diş beyazlatma işlemi ile dişleriniz doğal bir beyazlığa kavuşur.',
                'price' => $faker->numberBetween(1500, 3000) . ' ₺',
                'duration' => '60 dakika',
                'category' => 'estetik',
            ],
            [
                'name' => 'Diş Dolgusu',
                'description' => 'Çürük tedavisi sonrası estetik kompozit dolgu uygulaması.',
                'price' => $faker->numberBetween(300, 800) . ' ₺',
                'duration' => '30 dakika',
                'category' => 'genel',
            ],
            [
                'name' => 'Kanal Tedavisi',
                'description' => 'Diş sinirinin iltihaplanması durumunda uygulanan kök kanal tedavisi.',
                'price' => $faker->numberBetween(1000, 2500) . ' ₺',
                'duration' => '90 dakika',
                'category' => 'tedavi',
            ],
            [
                'name' => 'Diş Çekimi',
                'description' => 'Ağrılı ve tedavisi mümkün olmayan dişlerin çekim işlemi.',
                'price' => $faker->numberBetween(250, 500) . ' ₺',
                'duration' => '20 dakika',
                'category' => 'cerrahi',
            ],
            [
                'name' => 'İmplant Uygulaması',
                'description' => 'Eksik dişlerin yerine titanyum vida ile yapılan implant tedavisi.',
                'price' => $faker->numberBetween(3000, 6000) . ' ₺',
                'duration' => '120 dakika',
                'category' => 'implant',
            ],
            [
                'name' => 'Diş Taşı Temizliği',
                'description' => 'Ultrasonik cihazlar ile diş ve diş eti arasındaki diş taşlarının temizlenmesi.',
                'price' => $faker->numberBetween(400, 800) . ' ₺',
                'duration' => '45 dakika',
                'category' => 'koruyucu',
            ],
            [
                'name' => 'Gülüş Tasarımı',
                'description' => 'Kişiye özel estetik diş tedavileri ile yeni bir gülüş tasarımı.',
                'price' => $faker->numberBetween(5000, 15000) . ' ₺',
                'duration' => 'İki seans',
                'category' => 'estetik',
            ],
            [
                'name' => 'Ortodontik Tedavi',
                'description' => 'Tel veya şeffaf plaklar ile dişlerin düzeltilmesi tedavisi.',
                'price' => $faker->numberBetween(10000, 25000) . ' ₺',
                'duration' => '12-24 ay',
                'category' => 'ortodonti',
            ],
        ];
        
        // Select 3-6 random services
        $selectedServices = $faker->randomElements($services, $faker->numberBetween(3, 6));
        
        // Working hours for each day
        $workingHours = [];
        $days = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma'];
        $weekendOption = $faker->boolean(30); // 30% chance to work on weekends
        
        if ($weekendOption) {
            $days[] = 'Cumartesi';
        }
        
        foreach ($days as $day) {
            if ($faker->boolean(90)) { // 90% chance to work on each weekday
                $morningStart = $faker->randomElement(['08:30', '09:00', '09:30']);
                $morningEnd = $faker->randomElement(['12:00', '12:30', '13:00']);
                
                $afternoonStart = $faker->randomElement(['13:00', '13:30', '14:00']);
                $afternoonEnd = $faker->randomElement(['17:00', '17:30', '18:00']);
                
                // Some days might be half days
                if ($faker->boolean(20)) {
                    $workingHours[$day] = [$morningStart . '-' . $morningEnd];
                } else {
                    $workingHours[$day] = [$morningStart . '-' . $morningEnd, $afternoonStart . '-' . $afternoonEnd];
                }
            }
        }
        
        // Generate a bio for the dentist
        $bio = $faker->randomElement([
            "Merhaba, ben %s. %s alanında uzmanlaşmış bir diş hekimiyim. %s yılından beri hastalarıma en iyi diş sağlığı hizmetini sunmak için çalışıyorum. Hasta memnuniyeti ve kaliteli tedavi en önemli önceliğimdir.",
            "%s alanında uzman bir diş hekimi olarak, hastalarıma konforlu ve ağrısız tedavi sunmaya özen gösteriyorum. Modern teknikleri kullanarak, en güncel tedavi yöntemlerini kliniğimizde uyguluyoruz.",
            "Ben %s. Diş hekimliği eğitimimi %s Üniversitesi'nde tamamladım ve %s alanında uzmanlık aldım. Hastalarımın gülüşlerini güzelleştirmek ve diş sağlığını korumak için özenle çalışıyorum.",
            "%s yılından beri diş hekimi olarak görev yapıyorum. %s alanında uzmanlaşarak, hastalara özel tedavi planları sunuyorum. Modern teknikleri ve teknolojileri kullanarak, konforlu bir tedavi deneyimi sunmayı amaçlıyorum."
        ]);
        
        // Get random specialty and university
        $specialty = $faker->randomElement($specialties);
        $universities = ['Ankara', 'İstanbul', 'Ege', 'Hacettepe', 'Gazi', 'Marmara', '9 Eylül', 'Çukurova'];
        $university = $faker->randomElement($universities);
        $experience = $faker->numberBetween(1, 30);
        $startYear = date('Y') - $experience;
        
        // Format the bio with the specialty, university and start year
        $bio = sprintf($bio, $specialty, $university, $startYear);
        
        // Generate subdomain from a name
        $subdomain = Str::slug($name ?: $faker->firstName . $faker->lastName);
        
        return [
            'user_id' => User::factory(),
            'subdomain' => $subdomain,
            'title' => $faker->randomElement([
                $specialty . ' Uzmanı',
                'Uzman Diş Hekimi',
                'Estetik Diş Hekimi',
                'Ortodonti Uzmanı',
                'Çocuk Diş Hekimi'
            ]),
            'description' => $faker->paragraph(2),
            'content' => [
                'bio' => $bio,
                'specialties' => $faker->randomElements($specialties, $faker->numberBetween(1, 3)),
                'education' => [
                    [
                        'degree' => 'Diş Hekimliği Fakültesi',
                        'university' => $university . ' Üniversitesi',
                        'year' => $startYear - 6
                    ],
                    [
                        'degree' => $specialty . ' Uzmanlık',
                        'university' => $faker->randomElement($universities) . ' Üniversitesi',
                        'year' => $startYear - 2
                    ]
                ],
                'experience' => $experience . ' yıl',
                'location' => [
                    'city' => $faker->randomElement($cities),
                    'address' => $faker->address(),
                ]
            ],
            'working_hours' => $workingHours,
            'services' => $selectedServices,
            'social_media' => [
                'facebook' => $faker->boolean(70) ? 'https://facebook.com/dr.' . $subdomain : null,
                'instagram' => $faker->boolean(90) ? 'https://instagram.com/dr.' . $subdomain : null,
                'twitter' => $faker->boolean(50) ? 'https://twitter.com/dr.' . $subdomain : null,
                'linkedin' => $faker->boolean(60) ? 'https://linkedin.com/in/' . $subdomain : null,
            ],
            'contact_info' => [
                'phone' => $faker->phoneNumber(),
                'email' => $faker->email(),
                'whatsapp' => $faker->boolean(80) ? $faker->phoneNumber() : null,
            ],
            'is_active' => true,
        ];
    }
} 