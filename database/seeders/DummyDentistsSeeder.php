<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vitrin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DummyDentistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure dentist role exists
        if (!Role::where('name', 'dentist')->exists()) {
            Role::create(['name' => 'dentist']);
        }
        
        // List of dentists to create
        $dentists = [
            ['isim_soyisim' => 'Ahmet Yılmaz', 'mail_adresi' => 'ahmet.yilmaz@example.com', 'sifre' => 'password', 'city' => 'İzmir', 'specialty' => 'Protetik Diş Tedavisi'],
            ['isim_soyisim' => 'Ayşe Kaya', 'mail_adresi' => 'ayse.kaya@example.com', 'sifre' => 'password', 'city' => 'Ankara', 'specialty' => 'Ağız, Diş ve Çene Cerrahisi'],
            ['isim_soyisim' => 'Mehmet Demir', 'mail_adresi' => 'mehmet.demir@example.com', 'sifre' => 'password', 'city' => 'Antalya', 'specialty' => 'Periodontoloji'],
            ['isim_soyisim' => 'Fatma Çelik', 'mail_adresi' => 'fatma.celik@example.com', 'sifre' => 'password', 'city' => 'İstanbul', 'specialty' => 'Estetik Diş Hekimliği'],
            ['isim_soyisim' => 'Mustafa Şahin', 'mail_adresi' => 'mustafa.sahin@example.com', 'sifre' => 'password', 'city' => 'Bursa', 'specialty' => 'Pedodonti'],
            ['isim_soyisim' => 'Zeynep Arslan', 'mail_adresi' => 'zeynep.arslan@example.com', 'sifre' => 'password', 'city' => 'İzmir', 'specialty' => 'Genel Diş Hekimliği'],
            ['isim_soyisim' => 'Ali Can', 'mail_adresi' => 'ali.can@example.com', 'sifre' => 'password', 'city' => 'Ankara', 'specialty' => 'Ağız, Diş ve Çene Radyolojisi'],
            ['isim_soyisim' => 'Elif Yıldız', 'mail_adresi' => 'elif.yildiz@example.com', 'sifre' => 'password', 'city' => 'Antalya', 'specialty' => 'İmplantoloji'],
            ['isim_soyisim' => 'Hüseyin Öztürk', 'mail_adresi' => 'huseyin.ozturk@example.com', 'sifre' => 'password', 'city' => 'İstanbul', 'specialty' => 'Restoratif Diş Tedavisi'],
            ['isim_soyisim' => 'Sultan Aydın', 'mail_adresi' => 'sultan.aydin@example.com', 'sifre' => 'password', 'city' => 'Bursa', 'specialty' => 'Endodonti'],
            ['isim_soyisim' => 'Emre Aksoy', 'mail_adresi' => 'emre.aksoy@example.com', 'sifre' => 'password', 'city' => 'İzmir', 'specialty' => 'Ortodonti'],
            ['isim_soyisim' => 'Esra Doğan', 'mail_adresi' => 'esra.dogan@example.com', 'sifre' => 'password', 'city' => 'Ankara', 'specialty' => 'Protetik Diş Tedavisi'],
            ['isim_soyisim' => 'Murat Kılıç', 'mail_adresi' => 'murat.kilic@example.com', 'sifre' => 'password', 'city' => 'Antalya', 'specialty' => 'Ağız, Diş ve Çene Cerrahisi'],
            ['isim_soyisim' => 'Deniz Tekin', 'mail_adresi' => 'deniz.tekin@example.com', 'sifre' => 'password', 'city' => 'İstanbul', 'specialty' => 'Periodontoloji'],
            ['isim_soyisim' => 'Yusuf Koç', 'mail_adresi' => 'yusuf.koc@example.com', 'sifre' => 'password', 'city' => 'Bursa', 'specialty' => 'Estetik Diş Hekimliği'],
            ['isim_soyisim' => 'Gamze Çetin', 'mail_adresi' => 'gamze.cetin@example.com', 'sifre' => 'password', 'city' => 'İzmir', 'specialty' => 'Pedodonti'],
            ['isim_soyisim' => 'İbrahim Polat', 'mail_adresi' => 'ibrahim.polat@example.com', 'sifre' => 'password', 'city' => 'Ankara', 'specialty' => 'Genel Diş Hekimliği'],
            ['isim_soyisim' => 'Gizem Bulut', 'mail_adresi' => 'gizem.bulut@example.com', 'sifre' => 'password', 'city' => 'Antalya', 'specialty' => 'Ağız, Diş ve Çene Radyolojisi'],
            ['isim_soyisim' => 'Osman Yavuz', 'mail_adresi' => 'osman.yavuz@example.com', 'sifre' => 'password', 'city' => 'İstanbul', 'specialty' => 'İmplantoloji'],
            ['isim_soyisim' => 'Selin Gür', 'mail_adresi' => 'selin.gur@example.com', 'sifre' => 'password', 'city' => 'Bursa', 'specialty' => 'Restoratif Diş Tedavisi']
        ];
        
        // Clear existing dummy data
        $this->command->info("Cleaning up existing dummy data...");
        
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Delete existing dummy dentist users and their vitrins
            DB::table('vitrins')->delete();
            User::whereHas('roles', function($q) {
                $q->where('name', 'dentist');
            })->delete();
            
            $this->command->info("Creating new dummy dentists...");
            
            // Create the dentists
            foreach ($dentists as $dentistData) {
                // Create user
                $user = User::create([
                    'name' => $dentistData['isim_soyisim'],
                    'email' => $dentistData['mail_adresi'],
                    'password' => Hash::make($dentistData['sifre']),
                    'email_verified_at' => now(),
                ]);
                
                // Assign dentist role
                $user->assignRole('dentist');
                
                // Generate subdomain from name
                $nameParts = explode(' ', $dentistData['isim_soyisim']);
                $firstName = Str::slug($nameParts[0]);
                $lastName = isset($nameParts[1]) ? Str::slug($nameParts[1]) : '';
                $baseSubdomain = $firstName . ($lastName ? '-' . $lastName : '');
                $subdomain = $this->generateUniqueSubdomain($baseSubdomain);
                
                // Create vitrin profile
                $vitrin = Vitrin::create([
                    'user_id' => $user->id,
                    'subdomain' => $subdomain,
                    'title' => 'Dr. ' . $dentistData['isim_soyisim'],
                    'description' => $dentistData['specialty'] . ' uzmanı',
                    'content' => [
                        'bio' => $dentistData['specialty'] . ' alanında uzmanlaşmış deneyimli diş hekimi.',
                        'specialties' => [$dentistData['specialty']],
                        'location' => [
                            'city' => $dentistData['city'],
                            'address' => $dentistData['city'] . ' merkez',
                        ],
                    ],
                    'working_hours' => [
                        'monday' => ['09:00-12:00', '13:00-17:00'],
                        'tuesday' => ['09:00-12:00', '13:00-17:00'],
                        'wednesday' => ['09:00-12:00', '13:00-17:00'],
                        'thursday' => ['09:00-12:00', '13:00-17:00'],
                        'friday' => ['09:00-12:00', '13:00-17:00'],
                    ],
                    'services' => [
                        ['name' => 'Muayene', 'description' => 'Genel ağız ve diş muayenesi'],
                        ['name' => 'Diş Temizliği', 'description' => 'Profesyonel diş temizliği'],
                        ['name' => $dentistData['specialty'], 'description' => $dentistData['specialty'] . ' tedavileri'],
                    ],
                    'contact_info' => [
                        'email' => $dentistData['mail_adresi'],
                        'phone' => '0555' . rand(100, 999) . rand(10, 99) . rand(10, 99),
                    ],
                    'is_active' => true,
                ]);
                
                $this->command->info("Created dentist user: {$user->name} with vitrin subdomain: {$vitrin->subdomain}");
            }
            
            // Commit the transaction
            DB::commit();
            
            $this->command->info("Created " . count($dentists) . " dummy dentist users with vitrin profiles.");
            
        } catch (\Exception $e) {
            // Roll back the transaction in case of error
            DB::rollBack();
            $this->command->error("Error creating dummy dentists: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Generate a unique subdomain
     * If the suggested subdomain already exists, add a numeric suffix
     *
     * @param string $baseSubdomain
     * @return string
     */
    private function generateUniqueSubdomain(string $baseSubdomain): string
    {
        // Check if the base subdomain already exists
        if (!Vitrin::where('subdomain', $baseSubdomain)->exists()) {
            return $baseSubdomain;
        }
        
        // If it exists, try adding sequential numbers
        $count = 1;
        while (Vitrin::where('subdomain', $baseSubdomain . $count)->exists()) {
            $count++;
        }
        
        return $baseSubdomain . $count;
    }
} 