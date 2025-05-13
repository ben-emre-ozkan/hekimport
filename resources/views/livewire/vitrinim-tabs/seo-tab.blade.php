<div>
    <h2 class="text-xl font-medium text-gray-900 mb-6">SEO ve Görünüm</h2>
    
    <p class="text-gray-600 mb-6">Profilinizin arama motorlarındaki görünümünü ve platformda görünürlüğünü yönetin.</p>
    
    <!-- SEO Score Card Component -->
    <livewire:seo-score-card :vitrin="$vitrin" />
    
    <!-- Canonical URL Settings -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Profil URL Ayarları</h3>
        
        <div class="mb-4">
            <label for="subdomain" class="block text-sm font-medium text-gray-700 mb-1">Profil URL'niz</label>
            <div class="flex rounded-md shadow-sm">
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://hekimport.com/
                </span>
                <input 
                    type="text" 
                    id="subdomain" 
                    wire:model.defer="subdomain" 
                    placeholder="adsoyad"
                    class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
            </div>
            <p class="mt-2 text-sm text-gray-500">
                Profilinizin adresini kişiselleştirebilirsiniz. Sadece küçük harfler, rakamlar ve tire (-) kullanabilirsiniz.
            </p>
            <div class="mt-3 flex justify-end">
                <button
                    wire:click="updateSubdomain"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600"
                >
                    Profil URL'mi Güncelle
                </button>
            </div>
        </div>
        
        <p class="text-sm text-gray-600 mb-4 mt-6">
            Canonical URL, içeriğinizin asıl kaynağını arama motorlarına bildirir ve kopya içerik sorunlarını önler.
        </p>
        
        <div class="flex items-center">
            <span class="text-gray-700 mr-2">Canonical URL:</span>
            <span class="font-medium">https://hekimport.com/{{ $vitrin->subdomain ?? 'your-subdomain' }}</span>
        </div>
        
        <div class="mt-4">
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="useCustomDomain" 
                    wire:model="useCustomDomain"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="useCustomDomain" class="ml-2 block text-sm text-gray-700">
                    Özel alan adı (domain) kullan
                </label>
            </div>
            
            @if($useCustomDomain)
                <div class="mt-3">
                    <label for="customDomain" class="block text-sm font-medium text-gray-700 mb-1">Özel Alan Adı</label>
                    <div class="flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            https://
                        </span>
                        <input 
                            type="text" 
                            id="customDomain" 
                            wire:model="customDomain" 
                            placeholder="ornek.com"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Özel alan adı eklemek için DNS ayarlarınızı yapmanız gerekir. Detaylı bilgi için <a href="#" class="text-blue-600 hover:text-blue-800">buraya tıklayın</a>.
                    </p>
                </div>
                
                <div class="mt-3 flex justify-end">
                    <button 
                        wire:click="saveCustomDomain"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600"
                    >
                        Özel Alan Adını Kaydet
                    </button>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Social Media Preview -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Sosyal Medya Önizleme</h3>
        
        <p class="text-sm text-gray-600 mb-4">
            Profiliniz sosyal medyada paylaşıldığında nasıl görüneceğini önizleyin.
        </p>
        
        <div x-data="{ tab: 'facebook' }">
            <div class="border-b border-gray-200 mb-4">
                <nav class="flex -mb-px space-x-8">
                    <button
                        @click="tab = 'facebook'"
                        :class="tab === 'facebook' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-3 px-1 border-b-2 font-medium text-sm"
                    >
                        Facebook
                    </button>
                    <button
                        @click="tab = 'twitter'"
                        :class="tab === 'twitter' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-3 px-1 border-b-2 font-medium text-sm"
                    >
                        Twitter
                    </button>
                    <button
                        @click="tab = 'linkedin'"
                        :class="tab === 'linkedin' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-3 px-1 border-b-2 font-medium text-sm"
                    >
                        LinkedIn
                    </button>
                </nav>
            </div>
            
            <!-- Facebook Preview -->
            <div x-show="tab === 'facebook'" class="border border-gray-200 rounded-md overflow-hidden">
                <div class="bg-gray-100 p-4">
                    <div class="max-w-xl mx-auto">
                        <div class="bg-white rounded-md shadow-sm overflow-hidden">
                            @if($vitrin && $vitrin->getFirstMediaUrl('profile_photos', 'medium'))
                                <img 
                                    src="{{ $vitrin->getFirstMediaUrl('profile_photos', 'medium') }}" 
                                    alt="{{ $title }}"
                                    class="w-full h-60 object-cover"
                                >
                            @else
                                <div class="w-full h-60 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Profil resmi ekleyin</span>
                                </div>
                            @endif
                            <div class="p-3">
                                <div class="text-gray-500 text-xs">hekimport.com</div>
                                <h4 class="font-bold text-base mb-1 text-gray-900">{{ $title ?: 'Başlık Eklenmedi' }}</h4>
                                <p class="text-gray-600 text-sm">{{ $description ?: 'Henüz açıklama eklenmedi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Twitter Preview -->
            <div x-show="tab === 'twitter'" class="border border-gray-200 rounded-md overflow-hidden">
                <div class="bg-gray-100 p-4">
                    <div class="max-w-xl mx-auto">
                        <div class="bg-white rounded-md shadow-sm overflow-hidden">
                            @if($vitrin && $vitrin->getFirstMediaUrl('profile_photos', 'medium'))
                                <img 
                                    src="{{ $vitrin->getFirstMediaUrl('profile_photos', 'medium') }}" 
                                    alt="{{ $title }}"
                                    class="w-full h-52 object-cover"
                                >
                            @else
                                <div class="w-full h-52 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Profil resmi ekleyin</span>
                                </div>
                            @endif
                            <div class="p-3">
                                <h4 class="font-bold text-base mb-1 text-gray-900">{{ $title ?: 'Başlık Eklenmedi' }}</h4>
                                <p class="text-gray-600 text-sm">{{ $description ?: 'Henüz açıklama eklenmedi.' }}</p>
                                <div class="text-blue-500 text-xs mt-1">hekimport.com</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- LinkedIn Preview -->
            <div x-show="tab === 'linkedin'" class="border border-gray-200 rounded-md overflow-hidden">
                <div class="bg-gray-100 p-4">
                    <div class="max-w-xl mx-auto">
                        <div class="bg-white rounded-md shadow-sm overflow-hidden">
                            @if($vitrin && $vitrin->getFirstMediaUrl('profile_photos', 'medium'))
                                <img 
                                    src="{{ $vitrin->getFirstMediaUrl('profile_photos', 'medium') }}" 
                                    alt="{{ $title }}"
                                    class="w-full h-52 object-cover"
                                >
                            @else
                                <div class="w-full h-52 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Profil resmi ekleyin</span>
                                </div>
                            @endif
                            <div class="p-3">
                                <div class="text-gray-500 text-xs">hekimport.com</div>
                                <h4 class="font-bold text-base mb-1 text-gray-900">{{ $title ?: 'Başlık Eklenmedi' }}</h4>
                                <p class="text-gray-600 text-sm">{{ $description ?: 'Henüz açıklama eklenmedi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-sm text-gray-500">
            <p>Sosyal medya önizlemeleri, profilinizin sosyal medyada paylaşıldığında nasıl görüneceğini gösterir.</p>
            <p class="mt-1">Önizlemeyi geliştirmek için başlık, açıklama ve profil fotoğrafı ekleyin.</p>
        </div>
    </div>
    
    <!-- Keywords Settings -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Anahtar Kelimeler</h3>
        
        <p class="text-sm text-gray-600 mb-4">
            Anahtar kelimeler hastaların sizi aramalarda bulmasını sağlar. Uzmanlık alanınızı, lokasyonunuzu ve sunduğunuz hizmetleri içeren kelimeler ekleyin.
        </p>
        
        <div class="mb-4">
            <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Anahtar Kelimeler (virgülle ayırın)</label>
            <input 
                type="text" 
                id="keywords" 
                wire:model="keywords"
                placeholder="diş hekimi, ortodonti, gülüş tasarımı, implant, istanbul"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            >
        </div>
        
        <div class="flex items-start mb-4">
            <div class="flex items-center h-5">
                <input 
                    type="checkbox" 
                    id="autoGenerateKeywords" 
                    wire:model="autoGenerateKeywords"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
            </div>
            <div class="ml-3 text-sm">
                <label for="autoGenerateKeywords" class="font-medium text-gray-700">Anahtar kelimeleri otomatik oluştur</label>
                <p class="text-gray-500">Uzmanlık alanınız, lokasyonunuz ve hizmetlerinize göre anahtar kelimeler otomatik olarak oluşturulur.</p>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button 
                wire:click="saveKeywords"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600"
            >
                Anahtar Kelimeleri Kaydet
            </button>
        </div>
    </div>
    
    <!-- Görünürlük Ayarları -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Görünürlük Ayarları</h3>
        
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <button 
                    type="button"
                    wire:click="toggleVisibility"
                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white {{ $is_active ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($is_active)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        @endif
                    </svg>
                </button>
            </div>
            <div class="ml-3">
                <h4 class="text-base font-medium text-gray-900">Vitrinim {{ $is_active ? 'Yayında' : 'Gizli' }}</h4>
                <p class="text-sm text-gray-500">
                    @if($is_active)
                        Profiliniz şu anda Hekimport'ta görünür durumda ve hastalar tarafından bulunabilir.
                    @else
                        Profiliniz şu anda gizli durumda ve hastalar tarafından görüntülenemez.
                    @endif
                </p>
            </div>
        </div>
        
        <div class="mt-6 border-t border-gray-200 pt-6">
            <h4 class="text-base font-medium text-gray-900 mb-2">Görünürlük Seçenekleri</h4>
            
            <div class="space-y-4 mt-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox" 
                            id="showInSearch" 
                            wire:model="showInSearch"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="showInSearch" class="font-medium text-gray-700">Arama sonuçlarında görün</label>
                        <p class="text-gray-500">Profiliniz Hekimport üzerindeki aramalarda görünür.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox" 
                            id="showInDirectory" 
                            wire:model="showInDirectory"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="showInDirectory" class="font-medium text-gray-700">Hekim dizininde görün</label>
                        <p class="text-gray-500">Profiliniz hekim dizininde ve kategorilerde listelenir.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox" 
                            id="indexBySearchEngines" 
                            wire:model="indexBySearchEngines"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="indexBySearchEngines" class="font-medium text-gray-700">Arama motorlarında indekslen</label>
                        <p class="text-gray-500">Profiliniz Google, Yandex gibi arama motorlarında indekslenir.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <button 
                    wire:click="saveVisibilitySettings"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600"
                >
                    Görünürlük Ayarlarını Kaydet
                </button>
            </div>
        </div>
    </div>
</div> 