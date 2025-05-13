<?php

namespace App\Livewire;

use App\Models\Vitrin;
use App\Models\User;
use App\Enums\DentalSpecialty;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class VitrinimPage extends Component
{
    use WithFileUploads;

    // Tab management
    public string $tab = 'profile'; // Default tab: profile, slots, services, seo

    // Vitrin model
    public ?Vitrin $vitrin = null;
    
    // Form fields - Profile section
    public string $title = '';
    public string $description = '';
    public ?array $content = null;
    public ?array $contact_info = null;
    public ?array $social_media = null;
    public string $specialty = '';
    public string $bio = '';
    public string $city = '';
    public string $address = '';
    public bool $is_active = true;
    
    // Form fields - Slots section
    public ?array $working_hours = null;
    public string $selectedDay = 'Monday';
    public string $startTime = '09:00';
    public string $endTime = '10:00';
    
    // Form fields - Recurring slots
    public string $recurringPattern = 'weekly';
    public array $recurringDays = [0, 1, 2, 3, 4]; // Monday to Friday by default
    public string $recurringStartTime = '09:00';
    public string $recurringEndTime = '17:00';
    public int $recurringDuration = 30;
    public int $recurringInterval = 0;
    public ?array $previewSlots = null;
    public ?array $recurringTemplates = null;
    
    // Form fields - Vacation periods
    public ?string $vacationStartDate = null;
    public ?string $vacationEndDate = null;
    public ?string $vacationNote = null;
    public bool $notifyPatients = false;
    public ?array $vacationPeriods = null;
    
    // Form fields - Services section
    public ?array $services = null;
    public string $newServiceName = '';
    public string $newServiceDescription = '';
    public string $newServiceCategory = '';
    public string $newServicePrice = '';
    
    // Photo uploads
    public $profilePhoto = null;
    
    // Error/success messages
    public string $message = '';
    public string $messageType = 'success';
    
    // Form fields - SEO section
    public string $keywords = '';
    public bool $autoGenerateKeywords = true;
    public bool $useCustomDomain = false;
    public string $customDomain = '';
    public bool $showInSearch = true;
    public bool $showInDirectory = true;
    public bool $indexBySearchEngines = true;
    public string $subdomain = '';
    
    // For real-time validation
    protected $validationAttributes = [
        'title' => 'Başlık',
        'description' => 'Açıklama',
        'content.bio' => 'Biyografi',
        'contact_info.phone' => 'Telefon',
        'contact_info.email' => 'E-posta',
        'profilePhoto' => 'Profil fotoğrafı',
    ];
    
    // Allow updating the tab via query string
    protected $queryString = [
        'tab' => ['except' => 'profile']
    ];
    
    // Define validation rules
    protected function rules()
    {
        return [
            'title' => 'required|min:5|max:60',
            'description' => 'required|min:10|max:160',
            'content.bio' => 'required|min:20',
            'content.specialty' => 'required',
            'content.city' => 'required',
            'contact_info.phone' => 'required',
            'contact_info.email' => 'required|email',
            'is_active' => 'boolean',
            'profilePhoto' => 'nullable|image|max:2048', // 2MB max
        ];
    }
    
    public function mount()
    {
        $user = Auth::user();
        
        // Try to load existing Vitrin or prepare a new one
        $this->vitrin = $user->vitrin ?? new Vitrin();
        
        if ($this->vitrin->exists) {
            // Populate form fields from existing model
            $this->title = $this->vitrin->title ?? '';
            $this->description = $this->vitrin->description ?? '';
            $this->content = $this->vitrin->content ?? [
                'bio' => '',
                'specialty' => '',
                'city' => '',
                'address' => '',
            ];
            $this->specialty = $this->content['specialty'] ?? '';
            $this->bio = $this->content['bio'] ?? '';
            $this->city = $this->content['city'] ?? '';
            $this->address = $this->content['address'] ?? '';
            
            // Add subdomain from vitrin
            $this->subdomain = $this->vitrin->subdomain ?? '';
            
            $this->contact_info = is_array($this->vitrin->contact_info) 
                ? $this->vitrin->contact_info 
                : [
                    'phone' => '',
                    'email' => '',
                    'website' => '',
                ];
            $this->social_media = is_array($this->vitrin->social_media)
                ? $this->vitrin->social_media
                : [
                    'facebook' => '',
                    'instagram' => '',
                    'twitter' => '',
                    'linkedin' => '',
                ];
            $this->working_hours = is_array($this->vitrin->working_hours)
                ? $this->vitrin->working_hours
                : [
                    'Monday' => [],
                    'Tuesday' => [],
                    'Wednesday' => [],
                    'Thursday' => [],
                    'Friday' => [],
                    'Saturday' => [],
                    'Sunday' => [],
                ];
            $this->services = is_array($this->vitrin->services) ? $this->vitrin->services : [];
            $this->is_active = $this->vitrin->is_active;
            
            // Load recurring templates and vacation periods
            $this->recurringTemplates = $this->vitrin->content['recurring_templates'] ?? [];
            $this->vacationPeriods = $this->vitrin->content['vacation_periods'] ?? [];
            
            // Load SEO settings
            $this->keywords = $this->vitrin->content['keywords'] ?? '';
            $this->autoGenerateKeywords = $this->vitrin->content['auto_generate_keywords'] ?? true;
            
            // Load custom domain settings if they exist and the table exists
            if (Schema::hasTable('custom_domains')) {
                $customDomain = \App\Models\CustomDomain::where('vitrin_id', $this->vitrin->id)->first();
                if ($customDomain) {
                    $this->useCustomDomain = true;
                    $this->customDomain = $customDomain->domain;
                }
            } else {
                // Set default values if table doesn't exist (for testing)
                $this->useCustomDomain = false;
                $this->customDomain = '';
            }
            
            // Load visibility settings
            $this->showInSearch = $this->vitrin->content['show_in_search'] ?? true;
            $this->showInDirectory = $this->vitrin->content['show_in_directory'] ?? true;
            $this->indexBySearchEngines = $this->vitrin->content['index_by_search_engines'] ?? true;
        } else {
            // Initialize empty arrays for new vitrin
            $this->content = [
                'bio' => '',
                'specialty' => '',
                'city' => '',
                'address' => '',
            ];
            $this->contact_info = [
                'phone' => '',
                'email' => $user->email ?? '',
                'website' => '',
            ];
            $this->social_media = [
                'facebook' => '',
                'instagram' => '',
                'twitter' => '',
                'linkedin' => '',
            ];
            $this->working_hours = [
                'Monday' => [],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => [],
                'Saturday' => [],
                'Sunday' => [],
            ];
            $this->services = [];
            $this->recurringTemplates = [];
            $this->vacationPeriods = [];
        }
    }
    
    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }
    
    public function saveProfile()
    {
        // Validate profile fields
        $this->validate([
            'title' => 'required|min:5|max:60',
            'description' => 'required|min:10|max:160',
            'bio' => 'required|min:20',
            'specialty' => 'required',
            'city' => 'required',
            'contact_info.phone' => 'required',
            'contact_info.email' => 'required|email',
        ]);
        
        // Update content array with individual fields
        $this->content['bio'] = $this->bio;
        $this->content['specialty'] = $this->specialty;
        $this->content['city'] = $this->city;
        $this->content['address'] = $this->address;
        
        DB::beginTransaction();
        
        try {
            // Prepare Vitrin data
            $data = [
                'user_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'content' => $this->content,
                'contact_info' => $this->contact_info,
                'social_media' => $this->social_media,
                'is_active' => $this->is_active,
            ];
            
            // If it's a new vitrin, create it
            if (!$this->vitrin->exists) {
                // Generate a subdomain based on user's name
                $subdomain = strtolower(str_replace(' ', '', Auth::user()->name));
                $data['subdomain'] = $subdomain;
                
                // Create new vitrin
                $this->vitrin = Vitrin::create($data);
            } else {
                // Update existing vitrin
                $this->vitrin->update($data);
            }
            
            // Handle profile photo upload
            if ($this->profilePhoto) {
                $this->vitrin->addMedia($this->profilePhoto->getRealPath())
                    ->usingName($this->title)
                    ->toMediaCollection('profile_photos');
                
                $this->reset('profilePhoto');
            }
            
            DB::commit();
            
            $this->message = 'Profil bilgileri başarıyla kaydedildi.';
            $this->messageType = 'success';
            
            $this->dispatch('profile-saved');
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Profil bilgileri kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    public function saveSlots()
    {
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'working_hours' => $this->working_hours,
            ]);
            
            DB::commit();
            
            $this->message = 'Çalışma saatleri başarıyla kaydedildi.';
            $this->messageType = 'success';
            
            $this->dispatch('slots-saved');
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Çalışma saatleri kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    public function addSlot()
    {
        // Validate time format and order
        if (!$this->startTime || !$this->endTime) {
            $this->message = 'Başlangıç ve bitiş saatlerini seçmelisiniz.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->startTime >= $this->endTime) {
            $this->message = 'Başlangıç saati bitiş saatinden önce olmalıdır.';
            $this->messageType = 'error';
            return;
        }
        
        // Format: 09:00-10:00
        $slot = $this->startTime . '-' . $this->endTime;
        
        // Check if slot already exists for the selected day
        if (in_array($slot, $this->working_hours[$this->selectedDay])) {
            $this->message = 'Bu saat dilimi zaten eklenmiş.';
            $this->messageType = 'error';
            return;
        }
        
        // Add new slot
        $this->working_hours[$this->selectedDay][] = $slot;
        
        // Sort slots by time
        usort($this->working_hours[$this->selectedDay], function($a, $b) {
            $aStart = explode('-', $a)[0];
            $bStart = explode('-', $b)[0];
            return strcmp($aStart, $bStart);
        });
        
        // Auto-save after adding slot
        $this->saveSlots();
    }
    
    public function removeSlot($day, $slot)
    {
        // Find and remove the slot
        $index = array_search($slot, $this->working_hours[$day]);
        
        if ($index !== false) {
            unset($this->working_hours[$day][$index]);
            $this->working_hours[$day] = array_values($this->working_hours[$day]); // Reindex array
            
            // Auto-save after removing slot
            $this->saveSlots();
        }
    }
    
    /**
     * Toggle the selected day for recurring appointments
     */
    public function toggleRecurringDay($dayIndex)
    {
        $key = array_search($dayIndex, $this->recurringDays);
        
        if ($key !== false) {
            // Day is already selected, remove it
            unset($this->recurringDays[$key]);
            $this->recurringDays = array_values($this->recurringDays); // Reindex
        } else {
            // Add the day
            $this->recurringDays[] = $dayIndex;
            sort($this->recurringDays); // Sort numerically
        }
    }
    
    /**
     * Generate a preview of the recurring slots
     */
    public function generatePreviewSlots()
    {
        if (empty($this->recurringDays)) {
            $this->message = 'En az bir gün seçmelisiniz.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->recurringStartTime >= $this->recurringEndTime) {
            $this->message = 'Başlangıç saati bitiş saatinden önce olmalıdır.';
            $this->messageType = 'error';
            return;
        }
        
        // Map day indices to day names
        $dayMap = [
            0 => 'Monday',
            1 => 'Tuesday',
            2 => 'Wednesday',
            3 => 'Thursday',
            4 => 'Friday',
            5 => 'Saturday',
            6 => 'Sunday',
        ];
        
        $this->previewSlots = [];
        
        foreach ($this->recurringDays as $dayIndex) {
            $dayName = $dayMap[$dayIndex];
            $this->previewSlots[$dayName] = [];
            
            // Convert times to minutes from midnight for easier calculation
            $startMinutes = $this->timeToMinutes($this->recurringStartTime);
            $endMinutes = $this->timeToMinutes($this->recurringEndTime);
            
            // Calculate time slots
            $currentTime = $startMinutes;
            while ($currentTime + $this->recurringDuration <= $endMinutes) {
                $slotStart = $this->minutesToTime($currentTime);
                $slotEnd = $this->minutesToTime($currentTime + $this->recurringDuration);
                
                $this->previewSlots[$dayName][] = $slotStart . '-' . $slotEnd;
                
                // Move to next slot (appointment duration + interval)
                $currentTime += $this->recurringDuration + $this->recurringInterval;
            }
        }
        
        $this->message = 'Şablon önizlemesi oluşturuldu. Aşağıdaki saatleri kontrol ediniz.';
        $this->messageType = 'success';
    }
    
    /**
     * Apply the recurring slots to working hours
     */
    public function applyRecurringSlots()
    {
        if (empty($this->previewSlots)) {
            $this->generatePreviewSlots();
            
            if (empty($this->previewSlots)) {
                return; // Error already displayed
            }
        }
        
        // Apply generated slots to working hours
        foreach ($this->previewSlots as $day => $slots) {
            foreach ($slots as $slot) {
                if (!in_array($slot, $this->working_hours[$day])) {
                    $this->working_hours[$day][] = $slot;
                }
            }
            
            // Sort slots by time
            usort($this->working_hours[$day], function($a, $b) {
                $aStart = explode('-', $a)[0];
                $bStart = explode('-', $b)[0];
                return strcmp($aStart, $bStart);
            });
        }
        
        // Save the new template
        $newTemplate = [
            'days' => $this->recurringDays,
            'startTime' => $this->recurringStartTime,
            'endTime' => $this->recurringEndTime,
            'duration' => $this->recurringDuration,
            'interval' => $this->recurringInterval,
            'pattern' => $this->recurringPattern,
        ];
        
        if (!is_array($this->recurringTemplates)) {
            $this->recurringTemplates = [];
        }
        
        $this->recurringTemplates[] = $newTemplate;
        
        // Update the content array
        $this->content['recurring_templates'] = $this->recurringTemplates;
        
        // Save working hours and templates
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'working_hours' => $this->working_hours,
                'content' => $this->content,
            ]);
            
            DB::commit();
            
            $this->message = 'Tekrarlayan randevu şablonu uygulandı ve kaydedildi.';
            $this->messageType = 'success';
            
            $this->dispatch('slots-saved');
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Şablon uygulanırken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    /**
     * Load a saved recurring template
     */
    public function loadRecurringTemplate($index)
    {
        if (isset($this->recurringTemplates[$index])) {
            $template = $this->recurringTemplates[$index];
            
            $this->recurringDays = $template['days'];
            $this->recurringStartTime = $template['startTime'];
            $this->recurringEndTime = $template['endTime'];
            $this->recurringDuration = $template['duration'];
            $this->recurringInterval = $template['interval'];
            $this->recurringPattern = $template['pattern'] ?? 'weekly';
            
            $this->generatePreviewSlots();
            
            $this->message = 'Şablon yüklendi. Şablonu uygulamak için "Şablonu Uygula" butonuna tıklayın.';
            $this->messageType = 'success';
        }
    }
    
    /**
     * Delete a saved recurring template
     */
    public function deleteRecurringTemplate($index)
    {
        if (isset($this->recurringTemplates[$index])) {
            // Remove template
            unset($this->recurringTemplates[$index]);
            $this->recurringTemplates = array_values($this->recurringTemplates); // Reindex array
            
            // Update the content array
            $this->content['recurring_templates'] = $this->recurringTemplates;
            
            // Save templates
            DB::beginTransaction();
            
            try {
                $this->vitrin->update([
                    'content' => $this->content,
                ]);
                
                DB::commit();
                
                $this->message = 'Şablon başarıyla silindi.';
                $this->messageType = 'success';
            } catch (\Exception $e) {
                DB::rollBack();
                
                $this->message = 'Şablon silinirken bir hata oluştu: ' . $e->getMessage();
                $this->messageType = 'error';
            }
        }
    }
    
    /**
     * Add a vacation period
     */
    public function addVacationPeriod()
    {
        // Validate dates
        if (!$this->vacationStartDate || !$this->vacationEndDate) {
            $this->message = 'Başlangıç ve bitiş tarihlerini seçmelisiniz.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->vacationStartDate > $this->vacationEndDate) {
            $this->message = 'Başlangıç tarihi bitiş tarihinden önce olmalıdır.';
            $this->messageType = 'error';
            return;
        }
        
        // Create new vacation period
        $newPeriod = [
            'startDate' => $this->vacationStartDate,
            'endDate' => $this->vacationEndDate,
            'note' => $this->vacationNote,
            'notifyPatients' => $this->notifyPatients,
        ];
        
        if (!is_array($this->vacationPeriods)) {
            $this->vacationPeriods = [];
        }
        
        $this->vacationPeriods[] = $newPeriod;
        
        // Update the content array
        $this->content['vacation_periods'] = $this->vacationPeriods;
        
        // Save vacation periods
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'content' => $this->content,
            ]);
            
            DB::commit();
            
            // Reset form fields
            $this->reset(['vacationStartDate', 'vacationEndDate', 'vacationNote']);
            $this->notifyPatients = false;
            
            $this->message = 'İzin dönemi başarıyla eklendi.';
            $this->messageType = 'success';
            
            // If notification is enabled, trigger notification job
            if ($newPeriod['notifyPatients']) {
                // Dispatch a notification job (implementation depends on your notification system)
                // NotifyPatientsAboutVacation::dispatch($this->vitrin, $newPeriod);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'İzin dönemi eklenirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    /**
     * Delete a vacation period
     */
    public function deleteVacationPeriod($index)
    {
        if (isset($this->vacationPeriods[$index])) {
            // Remove period
            unset($this->vacationPeriods[$index]);
            $this->vacationPeriods = array_values($this->vacationPeriods); // Reindex array
            
            // Update the content array
            $this->content['vacation_periods'] = $this->vacationPeriods;
            
            // Save vacation periods
            DB::beginTransaction();
            
            try {
                $this->vitrin->update([
                    'content' => $this->content,
                ]);
                
                DB::commit();
                
                $this->message = 'İzin dönemi başarıyla silindi.';
                $this->messageType = 'success';
            } catch (\Exception $e) {
                DB::rollBack();
                
                $this->message = 'İzin dönemi silinirken bir hata oluştu: ' . $e->getMessage();
                $this->messageType = 'error';
            }
        }
    }
    
    /**
     * Helper: Convert time string (HH:MM) to minutes from midnight
     */
    private function timeToMinutes($time)
    {
        list($hours, $minutes) = explode(':', $time);
        return ($hours * 60) + $minutes;
    }
    
    /**
     * Helper: Convert minutes from midnight to time string (HH:MM)
     */
    private function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
    
    public function saveServices()
    {
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'services' => $this->services,
            ]);
            
            DB::commit();
            
            $this->message = 'Hizmetler başarıyla kaydedildi.';
            $this->messageType = 'success';
            
            $this->dispatch('services-saved');
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Hizmetler kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    public function addService()
    {
        // Validate service information
        if (empty($this->newServiceName)) {
            $this->message = 'Hizmet adı boş olamaz.';
            $this->messageType = 'error';
            return;
        }
        
        // Create a new service entry
        $this->services[] = [
            'name' => $this->newServiceName,
            'description' => $this->newServiceDescription,
            'category' => $this->newServiceCategory ?: 'general',
            'price' => $this->newServicePrice,
        ];
        
        // Reset form fields
        $this->reset(['newServiceName', 'newServiceDescription', 'newServiceCategory', 'newServicePrice']);
        
        $this->message = 'Hizmet başarıyla eklendi.';
        $this->messageType = 'success';
    }
    
    public function removeService($index)
    {
        if (isset($this->services[$index])) {
            // Remove service
            unset($this->services[$index]);
            $this->services = array_values($this->services); // Reindex array
            
            // Auto-save after removing service
            $this->saveServices();
        }
    }
    
    public function toggleVisibility()
    {
        $this->is_active = !$this->is_active;
        
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'is_active' => $this->is_active,
            ]);
            
            DB::commit();
            
            $status = $this->is_active ? 'aktif' : 'pasif';
            $this->message = "Vitrin görünürlüğü $status olarak ayarlandı.";
            $this->messageType = 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Vitrin görünürlüğü değiştirilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    // Return the dental specialties for the dropdown
    public function getDentalSpecialties()
    {
        return DentalSpecialty::getOptions();
    }
    
    /**
     * Reorder services using drag and drop
     */
    public function reorderServices($fromIndex, $toIndex)
    {
        if ($fromIndex === $toIndex) {
            return;
        }
        
        // Get the service to move
        $service = $this->services[$fromIndex];
        
        // Remove from original position
        array_splice($this->services, $fromIndex, 1);
        
        // Insert at new position
        array_splice($this->services, $toIndex, 0, [$service]);
        
        $this->message = 'Hizmet sırası güncellendi.';
        $this->messageType = 'success';
    }
    
    /**
     * Save custom domain settings
     */
    public function saveCustomDomain()
    {
        // Validate domain
        $this->validate([
            'customDomain' => 'required|regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
        ], [
            'customDomain.required' => 'Özel alan adı gereklidir.',
            'customDomain.regex' => 'Geçerli bir alan adı giriniz (örn: domain.com).',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Check if custom domain already exists
            $existingDomain = \App\Models\CustomDomain::where('domain', $this->customDomain)
                ->where('vitrin_id', '!=', $this->vitrin->id)
                ->first();
                
            if ($existingDomain) {
                $this->message = 'Bu alan adı başka bir hesap tarafından kullanılmaktadır.';
                $this->messageType = 'error';
                return;
            }
            
            // Create or update custom domain
            \App\Models\CustomDomain::updateOrCreate(
                ['vitrin_id' => $this->vitrin->id],
                ['domain' => $this->customDomain]
            );
            
            DB::commit();
            
            $this->message = 'Özel alan adı başarıyla kaydedildi.';
            $this->messageType = 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Özel alan adı kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    /**
     * Save keywords
     */
    public function saveKeywords()
    {
        if ($this->autoGenerateKeywords) {
            $this->keywords = $this->generateKeywords();
        }
        
        // Update content array
        $this->content['keywords'] = $this->keywords;
        $this->content['auto_generate_keywords'] = $this->autoGenerateKeywords;
        
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'content' => $this->content,
            ]);
            
            DB::commit();
            
            $this->message = 'Anahtar kelimeler başarıyla kaydedildi.';
            $this->messageType = 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Anahtar kelimeler kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    /**
     * Generate keywords automatically based on profile data
     */
    protected function generateKeywords()
    {
        $keywords = [];
        
        // Add specialty
        if (!empty($this->specialty)) {
            $specialtyLabel = DentalSpecialty::getOptions()[$this->specialty] ?? $this->specialty;
            $keywords[] = $specialtyLabel;
            $keywords[] = 'Diş hekimi ' . $specialtyLabel;
        }
        
        // Add location
        if (!empty($this->city)) {
            $keywords[] = $this->city . ' diş hekimi';
            $keywords[] = $this->city . ' ' . ($specialtyLabel ?? '');
        }
        
        // Add services
        if (is_array($this->services)) {
            foreach ($this->services as $service) {
                if (!empty($service['name'])) {
                    $keywords[] = $service['name'];
                    
                    if (!empty($this->city)) {
                        $keywords[] = $this->city . ' ' . $service['name'];
                    }
                }
            }
        }
        
        // Add common dental terms
        $keywords[] = 'diş hekimi';
        $keywords[] = 'dişçi';
        $keywords[] = 'diş kliniği';
        $keywords[] = 'diş tedavisi';
        
        // Remove duplicates and empty values
        $keywords = array_filter($keywords);
        $keywords = array_unique($keywords);
        
        // Limit to top 20 keywords
        $keywords = array_slice($keywords, 0, 20);
        
        return implode(', ', $keywords);
    }
    
    /**
     * Save visibility settings
     */
    public function saveVisibilitySettings()
    {
        // Update content array
        $this->content['show_in_search'] = $this->showInSearch;
        $this->content['show_in_directory'] = $this->showInDirectory;
        $this->content['index_by_search_engines'] = $this->indexBySearchEngines;
        
        DB::beginTransaction();
        
        try {
            $this->vitrin->update([
                'content' => $this->content,
            ]);
            
            DB::commit();
            
            $this->message = 'Görünürlük ayarları başarıyla kaydedildi.';
            $this->messageType = 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->message = 'Görünürlük ayarları kaydedilirken bir hata oluştu: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    /**
     * Update the user's subdomain
     */
    public function updateSubdomain()
    {
        // Validate the subdomain
        $this->validate([
            'subdomain' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('vitrins', 'subdomain')->ignore($this->vitrin->id)
            ],
        ], [
            'subdomain.required' => 'Profil URL\'niz boş olamaz.',
            'subdomain.min' => 'Profil URL\'niz en az 3 karakter olmalıdır.',
            'subdomain.max' => 'Profil URL\'niz en fazla 50 karakter olmalıdır.',
            'subdomain.regex' => 'Profil URL\'niz sadece küçük harfler, rakamlar ve tire (-) içerebilir.',
            'subdomain.unique' => 'Bu URL adresi başka bir kullanıcı tarafından kullanılıyor. Lütfen başka bir URL seçin.',
        ]);
        
        try {
            // Update the subdomain
            $this->vitrin->subdomain = $this->subdomain;
            $this->vitrin->save();
            
            // Show success message
            $this->message = 'Profil URL\'niz başarıyla güncellendi.';
            $this->messageType = 'success';
            
            // Dispatch an event to notify other components
            $this->dispatch('profile-saved');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Subdomain update failed: ' . $e->getMessage());
            
            // Show error message
            $this->message = 'Profil URL\'niz güncellenirken bir hata oluştu. Lütfen tekrar deneyin.';
            $this->messageType = 'error';
        }
    }
    
    public function render()
    {
        return view('livewire.vitrinim-page', [
            'dentalSpecialties' => $this->getDentalSpecialties(),
            'weekDays' => [
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
            ],
        ]);
    }
}
