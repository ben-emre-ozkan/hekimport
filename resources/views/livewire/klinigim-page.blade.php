<style>
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    }
    
    .aspect-w-16 > * {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-orbitron font-bold mb-2">Kliniğim</h1>
        <p class="text-gray-600">Klinik yönetim araçlarınız bu sayfada olacak.</p>
    </div>
    
    <!-- Coming Soon Banner -->
    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-lg shadow-xl p-6 mb-8"
         x-data="{ showDetails: false, animationComplete: false }" 
         x-init="setTimeout(() => animationComplete = true, 800)">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-orbitron font-bold mb-2"
                    x-show="animationComplete"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    Yakında Geliyor!
                </h2>
                <p class="mb-2" 
                   x-show="animationComplete"
                   x-transition:enter="transition ease-out duration-500 delay-200"
                   x-transition:enter-start="opacity-0 transform translate-y-2"
                   x-transition:enter-end="opacity-100 transform translate-y-0">
                    Kliniğim modülü geliştirme aşamasında ve yakında kullanımınıza sunulacak.
                </p>
                <button @click="showDetails = !showDetails" 
                        class="text-white underline focus:outline-none flex items-center mt-2"
                        x-show="animationComplete"
                        x-transition:enter="transition ease-out duration-500 delay-400"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100">
                    <span x-text="showDetails ? 'Detayları Gizle' : 'Detayları Göster'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform duration-300" :class="showDetails ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
            
            <div class="mt-4 md:mt-0" x-data="{ isSpinning: true }" x-init="setInterval(() => { isSpinning = !isSpinning }, 3000)">
                <div class="relative h-20 w-20 md:h-24 md:w-24" :class="{ 'animate-pulse': isSpinning }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div x-show="showDetails" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 transform -translate-y-2" 
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="mt-4">
            <p class="mb-2">Kliniğim modülü, diş hekimleri için kapsamlı klinik yönetim özellikleri sunacak:</p>
            <ul class="list-disc list-inside space-y-1 pl-4">
                <li>Hasta kayıtları ve tıbbi geçmiş yönetimi</li>
                <li>Randevu takvimi ve hatırlatıcılar</li>
                <li>Tedavi planları ve takibi</li>
                <li>Faturalandırma ve finansal raporlar</li>
                <li>Malzeme ve ekipman envanteri</li>
                <li>Personel programı ve izinler</li>
                <li>Gelişmiş raporlama ve analiz araçları</li>
                <li>Hasta iletişim portalı</li>
            </ul>
            <p class="mt-2">Aşağıdaki zaman çizelgesine göre özellikleri kademeli olarak sunmayı planlıyoruz.</p>
        </div>
    </div>

    <!-- Demo Video Placeholder -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-orbitron font-medium text-gray-900 mb-4">Kliniğim Tanıtım Videosu</h2>
        <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg flex flex-col items-center justify-center mb-4">
            <div class="text-center" 
                 x-data="{ hover: false }" 
                 @mouseenter="hover = true" 
                 @mouseleave="hover = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-2 transition-transform duration-300" :class="{ 'scale-110': hover }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-medium text-gray-900">Video Yakında</p>
                <p class="text-gray-600">Kliniğim modülü tanıtım videosu hazırlanıyor</p>
            </div>
        </div>
        <p class="text-gray-600">Kliniğim modülünün nasıl çalışacağını ve size nasıl zaman kazandıracağını detaylı olarak gösteren tanıtım videomuz çok yakında yayınlanacak.</p>
    </div>

    <!-- Feature Timeline -->
    <div class="mb-8">
        <h2 class="text-2xl font-orbitron font-medium text-gray-900 mb-6">Geliştirme Zaman Çizelgesi</h2>
        
        <div class="space-y-8">
            @foreach($features as $key => $feature)
                <div class="relative pl-8 pb-8 border-l-2 {{ !$loop->last ? 'border-blue-300' : 'border-transparent' }}">
                    <div class="absolute -left-2.5 top-0">
                        <div class="h-5 w-5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500"></div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-xl font-medium text-gray-900">{{ $feature['title'] }}</h3>
                                <p class="text-gray-600 mt-1">{{ $feature['description'] }}</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $feature['available'] ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $feature['available'] ? 'Kullanılabilir' : 'Tahmini: ' . $feature['eta'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Feedback Section with Animation -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-orbitron font-medium text-gray-900 mb-4">Geri Bildirim</h2>
        <p class="text-gray-600 mb-6">Kliniğim modülünden hangi özelliklere ihtiyacınız olduğunu bize bildirin. Geri bildirimleriniz geliştirme sürecimize yön verecek.</p>
        
        @if(session('success'))
            <div class="mb-4 p-4 rounded-md bg-green-50 text-green-800"
                 x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-show="show"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 rounded-md bg-red-50 text-red-800"
                 x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-show="show"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                {{ session('error') }}
            </div>
        @endif
        
        <form wire:submit.prevent="submitFeedback" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="feedbackName" class="block text-sm font-medium text-gray-700 mb-1">Adınız</label>
                    <input type="text" id="feedbackName" wire:model.live="feedbackName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Ad Soyad">
                    @error('feedbackName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="feedbackEmail" class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                    <input type="email" id="feedbackEmail" wire:model.live="feedbackEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="ornek@mail.com">
                    @error('feedbackEmail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div>
                <label for="feedbackType" class="block text-sm font-medium text-gray-700 mb-1">Geri Bildirim Türü</label>
                <select id="feedbackType" wire:model.live="feedbackType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="feature_request">Özellik Talebi</option>
                    <option value="improvement">İyileştirme Önerisi</option>
                    <option value="bug_report">Hata Bildirimi</option>
                    <option value="other">Diğer</option>
                </select>
            </div>
            
            <div>
                <label for="feedbackPriority" class="block text-sm font-medium text-gray-700 mb-1">Öncelik</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="feedbackPriority" value="low" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Düşük</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="feedbackPriority" value="medium" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Orta</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="feedbackPriority" value="high" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Yüksek</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label for="feedbackMessage" class="block text-sm font-medium text-gray-700 mb-1">Mesajınız</label>
                <textarea id="feedbackMessage" wire:model.live="feedbackMessage" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Kliniğim modülünden beklentilerinizi ve önerilerinizi paylaşın..."></textarea>
                @error('feedbackMessage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:-translate-y-1"
                    x-data="{ isHovering: false }"
                    @mouseenter="isHovering = true"
                    @mouseleave="isHovering = false"
                >
                    <svg wire:loading wire:target="submitFeedback" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Gönder</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Social Sharing Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-orbitron font-medium text-gray-900 mb-4">Paylaş</h2>
        <p class="text-gray-600 mb-4">Yeni Kliniğim modülümüzü meslektaşlarınızla paylaşın:</p>
        
        <div class="flex flex-wrap gap-4">
            <!-- Twitter Share Button -->
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareText) }}&url={{ urlencode($shareUrl) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#1DA1F2] hover:bg-[#0d8fd9] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1DA1F2] transition duration-150 ease-in-out transform hover:-translate-y-1"
               rel="noopener noreferrer">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                Twitter'da Paylaş
            </a>
            
            <!-- LinkedIn Share Button -->
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}&summary={{ urlencode($shareText) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0A66C2] hover:bg-[#0958a8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A66C2] transition duration-150 ease-in-out transform hover:-translate-y-1"
               rel="noopener noreferrer">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                LinkedIn'de Paylaş
            </a>
            
            <!-- WhatsApp Share Button -->
            <a href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#25D366] hover:bg-[#20bd5a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#25D366] transition duration-150 ease-in-out transform hover:-translate-y-1"
               rel="noopener noreferrer">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp'ta Paylaş
            </a>
            
            <!-- Email Share Button -->
            <a href="mailto:?subject={{ urlencode($shareTitle) }}&body={{ urlencode($shareText . ' ' . $shareUrl) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out transform hover:-translate-y-1">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                E-posta ile Paylaş
            </a>
        </div>
    </div>
    
    <!-- Newsletter Sign Up with Animation -->
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-lg shadow-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0 md:pr-4">
                <h3 class="text-xl font-orbitron font-medium text-white mb-2">Güncellemelerden Haberdar Olun</h3>
                <p class="text-white text-opacity-90">Yeni özellikler ve güncellemeler hakkında bilgi almak için e-posta listemize kaydolun.</p>
                
                @if(session('newsletter_success'))
                    <div class="mt-3 p-2 rounded-md bg-white bg-opacity-20 text-white"
                         x-data="{ show: true }"
                         x-init="setTimeout(() => show = false, 5000)"
                         x-show="show"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        {{ session('newsletter_success') }}
                    </div>
                @endif
                
                @if(session('newsletter_error'))
                    <div class="mt-3 p-2 rounded-md bg-red-500 bg-opacity-20 text-white"
                         x-data="{ show: true }"
                         x-init="setTimeout(() => show = false, 5000)"
                         x-show="show"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        {{ session('newsletter_error') }}
                    </div>
                @endif
            </div>
            <div class="w-full md:w-2/5">
                <form wire:submit.prevent="subscribeNewsletter">
                    <div class="flex">
                        <input type="email" wire:model.live="newsletterEmail" placeholder="E-posta adresiniz" class="w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <svg wire:loading wire:target="subscribeNewsletter" class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Kaydol</span>
                        </button>
                    </div>
                    @error('newsletterEmail') <span class="text-white text-sm mt-1 block">{{ $message }}</span> @enderror
                </form>
            </div>
        </div>
    </div>
</div> 