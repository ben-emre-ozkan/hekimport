<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KlinigimPage extends Component
{
    // Feature availability information with updated ETAs
    public array $features = [
        'clinic_info' => [
            'title' => 'Klinik Bilgileri',
            'description' => 'Kliniğinizin temel bilgilerini yönetin',
            'available' => false,
            'eta' => 'Nisan 2024'
        ],
        'patient_management' => [
            'title' => 'Hasta Yönetimi',
            'description' => 'Hasta kayıtlarını ve randevularını yönetin',
            'available' => false,
            'eta' => 'Mayıs 2024'
        ],
        'appointment_calendar' => [
            'title' => 'Randevu Takvimi',
            'description' => 'Günlük, haftalık ve aylık randevu takvimini görüntüleyin',
            'available' => false,
            'eta' => 'Mayıs 2024'
        ],
        'medical_records' => [
            'title' => 'Tıbbi Kayıtlar',
            'description' => 'Hastaların tıbbi geçmişini ve tedavi planlarını yönetin',
            'available' => false,
            'eta' => 'Haziran 2024'
        ],
        'billing' => [
            'title' => 'Faturalandırma',
            'description' => 'Tedavi ve hizmetlerin faturalandırmasını yönetin',
            'available' => false,
            'eta' => 'Temmuz 2024'
        ],
        'inventory' => [
            'title' => 'Envanter Yönetimi',
            'description' => 'Dental malzeme ve ekipman envanterini takip edin',
            'available' => false,
            'eta' => 'Ağustos 2024'
        ],
        'reports' => [
            'title' => 'Raporlar ve Analizler',
            'description' => 'Klinik performansı ve hasta istatistiklerini analiz edin',
            'available' => false,
            'eta' => 'Eylül 2024'
        ],
        'staff_management' => [
            'title' => 'Personel Yönetimi',
            'description' => 'Klinik personelinin izin ve mesai takibini yapın',
            'available' => false,
            'eta' => 'Ekim 2024'
        ],
    ];
    
    // User feedback
    public string $feedbackMessage = '';
    public string $feedbackName = '';
    public string $feedbackEmail = '';
    public string $feedbackType = 'feature_request';
    public string $feedbackPriority = 'medium';
    
    // Newsletter subscription
    public string $newsletterEmail = '';
    
    // Social sharing
    public string $shareUrl;
    public string $shareTitle = 'Hekimport\'un yeni Kliniğim modülünü sabırsızlıkla bekliyorum!';
    public string $shareText = 'Hekimport, diş hekimleri için kapsamlı bir klinik yönetim modülü geliştiriyor. Siz de inceleyin!';
    
    public function mount()
    {
        // Initialize social sharing URL
        $this->shareUrl = route('klinigim');
    }
    
    public function submitFeedback()
    {
        // Validate input
        $this->validate([
            'feedbackMessage' => 'required|min:10|max:1000',
            'feedbackName' => 'required|min:2|max:100',
            'feedbackEmail' => 'required|email|max:100',
            'feedbackType' => 'required|in:feature_request,bug_report,improvement,other',
            'feedbackPriority' => 'required|in:low,medium,high',
        ], [
            'feedbackMessage.required' => 'Lütfen bir geri bildirim mesajı girin.',
            'feedbackMessage.min' => 'Mesajınız en az 10 karakter olmalıdır.',
            'feedbackMessage.max' => 'Mesajınız en fazla 1000 karakter olabilir.',
            'feedbackName.required' => 'Lütfen adınızı girin.',
            'feedbackEmail.required' => 'Lütfen e-posta adresinizi girin.',
            'feedbackEmail.email' => 'Lütfen geçerli bir e-posta adresi girin.',
        ]);
        
        try {
            // Save feedback to database
            DB::table('feedback_suggestions')->insert([
                'user_id' => Auth::id(),
                'name' => $this->feedbackName,
                'email' => $this->feedbackEmail,
                'message' => $this->feedbackMessage,
                'type' => $this->feedbackType,
                'priority' => $this->feedbackPriority,
                'module' => 'klinigim',
                'status' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            session()->flash('success', 'Geri bildiriminiz için teşekkür ederiz! Ekibimiz inceleyecektir.');
            
            // Reset form
            $this->reset(['feedbackMessage', 'feedbackType', 'feedbackPriority']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Geri bildiriminiz kaydedilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    }
    
    public function subscribeNewsletter()
    {
        $this->validate([
            'newsletterEmail' => 'required|email|max:100',
        ], [
            'newsletterEmail.required' => 'Lütfen e-posta adresinizi girin.',
            'newsletterEmail.email' => 'Lütfen geçerli bir e-posta adresi girin.',
        ]);
        
        try {
            // Save newsletter subscription
            DB::table('newsletter_subscribers')->updateOrInsert(
                ['email' => $this->newsletterEmail],
                [
                    'user_id' => Auth::id(),
                    'module' => 'klinigim',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            
            session()->flash('newsletter_success', 'Bülten aboneliğiniz başarıyla kaydedildi!');
            $this->reset('newsletterEmail');
            
        } catch (\Exception $e) {
            session()->flash('newsletter_error', 'Bülten aboneliğiniz kaydedilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    }
    
    public function render()
    {
        return view('livewire.klinigim-page', [
            'user' => Auth::user(),
            'random_id' => Str::random(8), // For unique IDs in Alpine.js components
        ]);
    }
} 