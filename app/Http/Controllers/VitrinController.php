<?php

namespace App\Http\Controllers;

use App\Models\Vitrin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VitrinController extends Controller
{
    public function show(Request $request, $slug)
    {
        $vitrin = Vitrin::where('subdomain', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Record analytics safely
        try {
            $vitrin->analytics()->create([
                'metric' => 'visits',
                'value' => 1,
                'date' => now()->toDateString(),
                'event_type' => 'page_view',
                'source' => $request->header('referer'),
                'user_agent' => $request->userAgent(),
                'page' => 'profile',
            ]);
        } catch (\Exception $e) {
            // Log the error but continue without failing
            Log::error('Error recording vitrin analytics: ' . $e->getMessage());
        }

        return view('vitrin', compact('vitrin'));
    }

    /**
     * Display a test vitrin profile for checking layout and data handling
     */
    public function testProfile()
    {
        // Create a test vitrin with all required fields
        $vitrin = new Vitrin();
        $vitrin->id = 999;
        $vitrin->subdomain = 'test-dentist';
        $vitrin->title = 'Test Diş Hekimi';
        $vitrin->description = 'Bu bir test profilidir. Tasarım ve yerleşimin kontrol edilmesi için kullanılmaktadır.';
        
        // Add all required content data
        $vitrin->content = [
            'bio' => 'Merhaba, ben Test Diş Hekimi. Ortodonti alanında uzmanlaşmış bir diş hekimiyim. 2010 yılından beri hastalarıma en iyi diş sağlığı hizmetini sunmak için çalışıyorum. Hasta memnuniyeti ve kaliteli tedavi en önemli önceliğimdir.',
            'specialties' => ['Ortodonti', 'Genel Diş Hekimliği', 'Estetik Diş Hekimliği'],
            'education' => [
                [
                    'university' => 'Ankara Üniversitesi',
                    'degree' => 'Diş Hekimliği Fakültesi',
                    'year' => '2008'
                ],
                [
                    'university' => 'İstanbul Üniversitesi',
                    'degree' => 'Ortodonti Uzmanlık',
                    'year' => '2012'
                ]
            ],
            'location' => [
                'city' => 'İstanbul', 
                'address' => 'Bağdat Caddesi No:123, Kadıköy, İstanbul',
                'country' => 'TR'
            ],
            'contact' => [
                'phone' => '+90 555 123 45 67',
                'email' => 'test@hekimport.com',
                'whatsapp' => '+90 555 123 45 67'
            ]
        ];
        
        // Working hours for each day
        $vitrin->working_hours = [
            'Pazartesi' => ['09:00-12:00', '13:00-17:00'],
            'Salı' => ['09:00-12:00', '13:00-17:00'],
            'Çarşamba' => ['09:00-12:00', '13:00-17:00'],
            'Perşembe' => ['09:00-12:00', '13:00-17:00'],
            'Cuma' => ['09:00-12:00', '13:00-17:00'],
            'Cumartesi' => ['10:00-14:00']
        ];
        
        // Services with categories
        $vitrin->services = [
            [
                'name' => 'Diş Beyazlatma',
                'description' => 'Profesyonel diş beyazlatma işlemi ile dişleriniz doğal bir beyazlığa kavuşur.',
                'price' => '2000 ₺',
                'duration' => '60 dakika',
                'category' => 'estetik',
            ],
            [
                'name' => 'Diş Dolgusu',
                'description' => 'Çürük tedavisi sonrası estetik kompozit dolgu uygulaması.',
                'price' => '500 ₺',
                'duration' => '30 dakika',
                'category' => 'genel',
            ],
            [
                'name' => 'Kanal Tedavisi',
                'description' => 'Diş sinirinin iltihaplanması durumunda uygulanan kök kanal tedavisi.',
                'price' => '1500 ₺',
                'duration' => '90 dakika',
                'category' => 'tedavi',
            ],
        ];
        
        // Contact info
        $vitrin->contact_info = [
            'phone' => '+90 555 123 45 67',
            'email' => 'test@hekimport.com',
            'whatsapp' => '+90 555 123 45 67'
        ];
        
        // Social media links
        $vitrin->social_media = [
            'facebook' => 'https://facebook.com/dr.testdentist',
            'instagram' => 'https://instagram.com/dr.testdentist',
            'twitter' => 'https://twitter.com/dr.testdentist'
        ];
        
        $vitrin->is_active = true;
        
        return view('vitrin', compact('vitrin'));
    }
} 