<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- SEO Score -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 col-span-1">
            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Puanı</h3>
            
            <div x-data="{ analyzing: @entangle('analyzing') }">
                <!-- Loading state -->
                <div x-show="analyzing" class="flex items-center justify-center py-8">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="ml-3 text-gray-700">SEO analizi yapılıyor...</span>
                </div>
                
                <!-- Score display -->
                <div x-show="!analyzing" class="text-center py-4">
                    <div class="relative inline-block h-36 w-36">
                        <svg class="w-full h-full" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background circle -->
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="2"></circle>
                            
                            <!-- Score circle with dynamic color based on score -->
                            <circle 
                                cx="18" cy="18" r="16" 
                                fill="none" 
                                stroke="{{ $score >= 80 ? '#10b981' : ($score >= 50 ? '#3b82f6' : '#ef4444') }}" 
                                stroke-width="2" 
                                stroke-dasharray="100"
                                stroke-dashoffset="{{ 100 - $score }}"
                                transform="rotate(-90 18 18)"
                            ></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-3xl font-bold">{{ $score }}</span>
                            <span class="text-xs text-gray-500">/ 100</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="font-medium text-lg">
                            @if($score >= 80)
                                <span class="text-green-600">Mükemmel!</span>
                            @elseif($score >= 60)
                                <span class="text-blue-600">İyi</span>
                            @elseif($score >= 40)
                                <span class="text-yellow-600">Orta</span>
                            @else
                                <span class="text-red-600">Geliştirmeniz Gerekiyor</span>
                            @endif
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">Profilinizin SEO puanı</p>
                    </div>
                    
                    <button
                        wire:click="analyze"
                        class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Yeniden Analiz Et
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Meta Preview -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 col-span-1 md:col-span-2">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Meta Önizleme</h3>
            
            <div class="p-4 border border-gray-200 rounded-md">
                <div class="text-xl text-blue-700 mb-1 truncate">{{ $metaPreview['title'] }}</div>
                <div class="text-green-700 text-sm mb-2 truncate">{{ $metaPreview['url'] }}</div>
                <div class="text-gray-600 text-sm">{{ $metaPreview['description'] }}</div>
            </div>
            
            <div class="mt-4 text-sm text-gray-500">
                <p>Google ve diğer arama motorlarında görünecek olan başlık ve açıklama metni yukarıdaki gibi olacaktır.</p>
                <p class="mt-1">Başlık ve açıklama alanlarını düzenlemek için "Profil Bilgileri" sekmesini kullanabilirsiniz.</p>
            </div>
        </div>
    </div>
    
    <!-- SEO Analysis Details -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Analiz Detayları</h3>
        
        <div class="space-y-3">
            @foreach($results as $key => $result)
                @if($key !== 'score')
                    <div class="p-3 border rounded-md" 
                        :class="{{ $result['status'] ? 'border-green-200 bg-green-50' : 'border-yellow-200 bg-yellow-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($result['status'])
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-10a1 1 0 10-2 0v4a1 1 0 102 0V8zm0 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium" 
                                   :class="{{ $result['status'] ? 'text-green-800' : 'text-yellow-800' }}">
                                    {{ $result['recommendation'] }}
                                </p>
                                @if(isset($result['value']))
                                    <p class="text-sm" 
                                       :class="{{ $result['status'] ? 'text-green-600' : 'text-yellow-600' }}">
                                        Mevcut: {{ $result['value'] ?: '-' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Schema.org Markup -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Schema.org İşaretlemesi</h3>
        
        <p class="text-sm text-gray-600 mb-4">
            Schema.org işaretlemeleri, arama motorlarının içeriğinizi daha iyi anlamasını ve zengin sonuçlar göstermesini sağlar.
            Aşağıdaki JSON-LD kodu otomatik olarak sitenize eklenir:
        </p>
        
        @if($schemaData)
            <div class="relative">
                <pre class="p-4 bg-gray-800 text-green-400 rounded-md text-sm overflow-x-auto" style="max-height: 300px">{{ $schemaData }}</pre>
                
                <button
                    x-data="{}"
                    @click="navigator.clipboard.writeText($el.previousElementSibling.textContent); $el.querySelector('span').textContent = 'Kopyalandı!'; setTimeout(() => $el.querySelector('span').textContent = 'Kopyala', 2000)"
                    class="absolute top-2 right-2 inline-flex items-center px-2 py-1 border border-gray-700 shadow-sm text-xs font-medium rounded-md text-gray-300 bg-gray-900 hover:bg-gray-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Kopyala</span>
                </button>
            </div>
        @else
            <div class="text-center py-6 bg-gray-50 rounded-md text-gray-500">
                <p>Schema.org işaretlemesi oluşturmak için önce profil bilgilerinizi kaydedin.</p>
            </div>
        @endif
    </div>
    
    <!-- Improvement Suggestions -->
    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Önerileri</h3>
        
        @if(count($improvementSuggestions) > 0)
            <ul class="space-y-2 text-sm text-gray-600">
                @foreach($improvementSuggestions as $suggestion)
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $suggestion }}
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center py-6 bg-green-50 rounded-md text-green-600">
                <p>Harika! Tüm SEO önerilerini uyguladınız.</p>
            </div>
        @endif
    </div>
</div> 