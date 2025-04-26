<div class="min-h-screen bg-gradient-to-br from-teal-400 via-blue-500 to-teal-400 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center mb-4">
                <span class="text-4xl">🦷</span>
                <h1 class="ml-3 text-4xl font-orbitron font-bold text-white">HEKİMPORT</h1>
            </div>
            <p class="mt-2 text-xl text-white/90">Türkiye'nin En Kapsamlı Diş Hekimi Arama Platformu</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="query" class="block text-sm font-medium text-gray-700">Diş Hekimi veya Uzmanlık Ara</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" wire:model.live.debounce.300ms="query" id="query"
                            class="block w-full rounded-lg border-gray-300 pl-4 pr-12 focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                            placeholder="Örn: Ortodonti, Dr. Ahmet"
                            aria-label="Diş hekimi veya uzmanlık ara">
                    </div>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Şehir</label>
                    <select wire:model.live="city" id="city"
                        class="mt-1 block w-full rounded-lg border-gray-300 pl-3 pr-10 text-base focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                        aria-label="Şehir seçin">
                        <option value="">Tüm Şehirler</option>
                        @foreach($cities as $cityOption)
                            <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="specialty" class="block text-sm font-medium text-gray-700">Uzmanlık</label>
                    <select wire:model.live="specialty" id="specialty"
                        class="mt-1 block w-full rounded-lg border-gray-300 pl-3 pr-10 text-base focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                        aria-label="Uzmanlık seçin">
                        <option value="">Tüm Uzmanlıklar</option>
                        @foreach($specialties as $specialtyOption)
                            <option value="{{ $specialtyOption }}">{{ $specialtyOption }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div wire:loading wire:target="query, city, specialty" class="flex justify-center my-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white"></div>
        </div>

        <!-- Results -->
        <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vitrins as $vitrin)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $vitrin->name }}</h3>
                            <span class="text-2xl">🦷</span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($vitrin->bio, 100) }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                                {{ $vitrin->city }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $vitrin->specialty }}
                            </span>
                        </div>
                        
                        <a href="http://{{ $vitrin->subdomain }}.hekimport.local" 
                           class="block w-full text-center px-4 py-2 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-lg hover:from-teal-600 hover:to-blue-600 transition-colors duration-300"
                           aria-label="Vitrini görüntüle">
                            Vitrini Görüntüle
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-lg">
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Sonuç Bulunamadı</h3>
                    <p class="text-gray-600">Lütfen farklı arama kriterleri deneyin.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $vitrins->links() }}
        </div>
    </div>
</div> 