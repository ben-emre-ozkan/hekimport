<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vitrin;
use Illuminate\Support\Str;

class SeoScoreCard extends Component
{
    public ?Vitrin $vitrin = null;
    public bool $analyzing = false;
    public int $score = 0;
    public array $results = [];
    public ?string $title = null;
    public ?string $description = null;
    public ?array $services = null;
    public ?array $content = null;
    
    /**
     * Mount the component with the given vitrin
     */
    public function mount(Vitrin $vitrin = null)
    {
        $this->vitrin = $vitrin;
        
        if ($this->vitrin) {
            $this->title = $this->vitrin->title;
            $this->description = $this->vitrin->description;
            $this->services = is_array($this->vitrin->services) ? $this->vitrin->services : [];
            $this->content = $this->vitrin->content;
            
            // Auto-analyze on mount
            $this->analyze();
        }
    }
    
    /**
     * Perform SEO analysis
     */
    public function analyze()
    {
        $this->analyzing = true;
        
        // Initialize results
        $this->results = [
            'title' => [
                'status' => false,
                'value' => $this->title,
                'recommendation' => 'Başlık 10-60 karakter arası olmalıdır',
            ],
            'description' => [
                'status' => false,
                'value' => $this->description,
                'recommendation' => 'Açıklama 50-160 karakter arası olmalıdır',
            ],
            'keywords' => [
                'status' => false,
                'recommendation' => 'Anahtar kelimeler başlık ve açıklamada geçmelidir',
            ],
            'services' => [
                'status' => false,
                'value' => is_array($this->services) ? count($this->services) : 0,
                'recommendation' => 'En az 3 hizmet ekleyin',
            ],
            'gallery' => [
                'status' => false,
                'value' => $this->vitrin ? $this->vitrin->getMedia('gallery')->count() : 0,
                'recommendation' => 'En az 3 fotoğraf ekleyin',
            ],
            'contact' => [
                'status' => false,
                'recommendation' => 'İletişim bilgilerinizi eksiksiz doldurun',
            ],
            'profile_photo' => [
                'status' => false,
                'recommendation' => 'Profil fotoğrafı ekleyin',
            ],
            'bio_length' => [
                'status' => false,
                'recommendation' => 'Biyografi en az 200 karakter olmalıdır',
            ],
            'schema_markup' => [
                'status' => false,
                'recommendation' => 'Schema.org işaretlemeleri eklenmelidir',
            ],
            'canonical_url' => [
                'status' => false,
                'recommendation' => 'Canonical URL tanımlanmalıdır',
            ],
        ];
        
        // Calculate score
        $this->calculateScore();
        
        $this->analyzing = false;
    }
    
    /**
     * Calculate SEO score based on various factors
     */
    protected function calculateScore()
    {
        $totalScore = 0;
        $maxScore = 100;
        $criteria = 10; // Total number of criteria
        
        // Title length (10-60 characters)
        if ($this->title && strlen($this->title) >= 10 && strlen($this->title) <= 60) {
            $this->results['title']['status'] = true;
            $totalScore += 10;
        }
        
        // Description length (50-160 characters)
        if ($this->description && strlen($this->description) >= 50 && strlen($this->description) <= 160) {
            $this->results['description']['status'] = true;
            $totalScore += 10;
        }
        
        // Keywords in title and description
        $keywords = $this->extractKeywords();
        if (!empty($keywords)) {
            $titleMatches = 0;
            $descMatches = 0;
            
            foreach ($keywords as $keyword) {
                if (Str::contains(strtolower($this->title), strtolower($keyword))) {
                    $titleMatches++;
                }
                
                if (Str::contains(strtolower($this->description), strtolower($keyword))) {
                    $descMatches++;
                }
            }
            
            if ($titleMatches >= 1 && $descMatches >= 2) {
                $this->results['keywords']['status'] = true;
                $totalScore += 10;
            } else {
                $this->results['keywords']['recommendation'] = 'En az 1 anahtar kelime başlıkta, 2 anahtar kelime açıklamada bulunmalıdır.';
            }
        }
        
        // Services (at least 3)
        if (is_array($this->services) && count($this->services) >= 3) {
            $this->results['services']['status'] = true;
            $totalScore += 10;
        }
        
        // Gallery (at least 3 images)
        $galleryCount = $this->vitrin ? $this->vitrin->getMedia('gallery')->count() : 0;
        if ($galleryCount >= 3) {
            $this->results['gallery']['status'] = true;
            $totalScore += 10;
        }
        
        // Contact information (phone, email, address)
        if (isset($this->vitrin->contact_info['phone']) && !empty($this->vitrin->contact_info['phone']) &&
            isset($this->vitrin->contact_info['email']) && !empty($this->vitrin->contact_info['email']) &&
            isset($this->content['address']) && !empty($this->content['address'])) {
            $this->results['contact']['status'] = true;
            $totalScore += 10;
        } else {
            $missingFields = [];
            if (empty($this->vitrin->contact_info['phone'])) $missingFields[] = 'telefon';
            if (empty($this->vitrin->contact_info['email'])) $missingFields[] = 'e-posta';
            if (empty($this->content['address'])) $missingFields[] = 'adres';
            
            $this->results['contact']['recommendation'] = 'Eksik bilgileri doldurun: ' . implode(', ', $missingFields);
        }
        
        // Profile photo
        if ($this->vitrin && $this->vitrin->getFirstMedia('profile_photos')) {
            $this->results['profile_photo']['status'] = true;
            $totalScore += 10;
        }
        
        // Bio length (at least 200 characters)
        if (isset($this->content['bio']) && strlen($this->content['bio']) >= 200) {
            $this->results['bio_length']['status'] = true;
            $totalScore += 10;
        } else {
            $currentLength = isset($this->content['bio']) ? strlen($this->content['bio']) : 0;
            $this->results['bio_length']['recommendation'] = "Biyografi en az 200 karakter olmalıdır (şu anki: $currentLength)";
        }
        
        // Schema.org markup
        // This is typically handled automatically by the site
        $this->results['schema_markup']['status'] = true;
        $totalScore += 10;
        
        // Canonical URL
        // This is typically handled automatically by the site
        $this->results['canonical_url']['status'] = true;
        $totalScore += 10;
        
        // Calculate final score
        $this->score = (int)($totalScore * $maxScore / ($criteria * 10));
        
        // Add score to results
        $this->results['score'] = $this->score;
    }
    
    /**
     * Extract potential keywords from content
     */
    protected function extractKeywords()
    {
        $keywords = [];
        
        // Get specialty as a keyword
        if (isset($this->content['specialty']) && !empty($this->content['specialty'])) {
            $keywords[] = $this->content['specialty'];
        }
        
        // Get city as a keyword
        if (isset($this->content['city']) && !empty($this->content['city'])) {
            $keywords[] = $this->content['city'];
        }
        
        // Extract service names as keywords
        if (is_array($this->services)) {
            foreach ($this->services as $service) {
                if (isset($service['name']) && !empty($service['name'])) {
                    $keywords[] = $service['name'];
                }
            }
        }
        
        // Remove duplicates and limit to top 5
        $keywords = array_unique($keywords);
        $keywords = array_slice($keywords, 0, 5);
        
        return $keywords;
    }
    
    /**
     * Generate SEO meta preview
     */
    public function getMetaPreview()
    {
        return [
            'title' => $this->title ?: 'Başlık Eklenmedi',
            'url' => $this->vitrin ? 'hekimport.com/' . $this->vitrin->subdomain : 'hekimport.com/your-subdomain',
            'description' => $this->description ?: 'Henüz açıklama eklenmedi. Profilinizin arama motorlarında daha iyi görünmesi için açıklama ekleyin.',
        ];
    }
    
    /**
     * Generate schema.org JSON-LD data
     */
    public function getSchemaData()
    {
        if (!$this->vitrin) {
            return null;
        }
        
        $name = $this->vitrin->title;
        $description = $this->vitrin->description;
        $url = 'https://hekimport.com/' . $this->vitrin->subdomain;
        $imageUrl = $this->vitrin->getFirstMediaUrl('profile_photos', 'medium') ?: '';
        $address = $this->content['address'] ?? '';
        $city = $this->content['city'] ?? '';
        $phone = $this->vitrin->contact_info['phone'] ?? '';
        $email = $this->vitrin->contact_info['email'] ?? '';
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Dentist',
            'name' => $name,
            'description' => $description,
            'url' => $url,
            'image' => $imageUrl,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => $city,
                'addressCountry' => 'TR'
            ],
            'telephone' => $phone,
            'email' => $email,
            'priceRange' => '$$',
            'openingHoursSpecification' => $this->generateOpeningHours(),
        ];
        
        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Generate openingHoursSpecification for schema
     */
    protected function generateOpeningHours()
    {
        if (!$this->vitrin) {
            return [];
        }
        
        $dayMap = [
            'Monday' => 'Pazartesi',
            'Tuesday' => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday' => 'Perşembe',
            'Friday' => 'Cuma',
            'Saturday' => 'Cumartesi',
            'Sunday' => 'Pazar',
        ];
        
        $openingHours = [];
        
        // Check if working_hours is an array before iterating
        $workingHours = $this->vitrin->working_hours;
        if (!is_array($workingHours)) {
            return $openingHours;
        }
        
        foreach ($workingHours as $day => $slots) {
            if (empty($slots)) {
                continue;
            }
            
            // Get the earliest start time and latest end time
            $startTimes = [];
            $endTimes = [];
            
            foreach ($slots as $slot) {
                list($start, $end) = explode('-', $slot);
                $startTimes[] = $start;
                $endTimes[] = $end;
            }
            
            sort($startTimes);
            rsort($endTimes);
            
            $openingHours[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'https://schema.org/' . $day,
                'opens' => $startTimes[0],
                'closes' => $endTimes[0],
            ];
        }
        
        return $openingHours;
    }
    
    /**
     * Get SEO improvement suggestions
     */
    public function getImprovementSuggestions()
    {
        $suggestions = [];
        
        foreach ($this->results as $key => $result) {
            if ($key !== 'score' && !$result['status']) {
                $suggestions[] = $result['recommendation'];
            }
        }
        
        return $suggestions;
    }
    
    public function render()
    {
        return view('livewire.seo-score-card', [
            'metaPreview' => $this->getMetaPreview(),
            'schemaData' => $this->getSchemaData(),
            'improvementSuggestions' => $this->getImprovementSuggestions(),
        ]);
    }
} 