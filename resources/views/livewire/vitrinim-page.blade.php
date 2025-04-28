<!DOCTYPE html>
<div class="w-full" x-data="{ activeTab: '{{ $tab }}', isMobileMenuOpen: false }">
    <style>
        .tab-button {
            @apply whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors duration-150 ease-in-out;
        }
        .tab-button-active {
            @apply border-[#00c8b3] text-[#00c8b3];
        }
        .tab-button-inactive {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .card-hover {
            @apply transition duration-300 ease-in-out hover:shadow-2xl;
        }
        /* Subtle animation for tab content */
        .tab-content > div {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 card-hover">
        <!-- Header with brand gradient -->
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-[#00c8b3] to-[#0099e5] rounded-lg opacity-10"></div>
            <div class="relative flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 px-5">
                <div class="flex items-center mb-4 sm:mb-0">
                    <!-- Logo SVG -->
                    <svg class="w-8 h-8 mr-3 text-[#00c8b3]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 011.5 1.5v10a1.5 1.5 0 01-3 0v-10A1.5 1.5 0 0110 3.5zM13.5 6a1.5 1.5 0 010 3h-7a1.5 1.5 0 010-3h7z"/>
                    </svg>
                    <h1 class="text-2xl sm:text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#00c8b3] to-[#0099e5] font-bold">Vitrinim</h1>
                </div>

                <!-- Mobile Tab Select -->
                <div class="sm:hidden w-full">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <select id="tabs" name="tabs" x-model="activeTab" @change="isMobileMenuOpen = false" class="block w-full rounded-md border-gray-300 focus:border-[#00c8b3] focus:ring-[#00c8b3]">
                        <option value="profile">Profil</option>
                        <option value="analytics">Analitik</option>
                        <option value="settings">Ayarlar</option>
                    </select>
                </div>

                <!-- Desktop Tab Buttons -->
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                            <button @click="activeTab = 'profile'" 
                                    :class="activeTab === 'profile' ? 'tab-button-active' : 'tab-button-inactive'" 
                                    class="tab-button">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil
                                </span>
                            </button>
                            <button @click="activeTab = 'analytics'" 
                                    :class="activeTab === 'analytics' ? 'tab-button-active' : 'tab-button-inactive'" 
                                    class="tab-button">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Analitik
                                </span>
                            </button>
                            <button @click="activeTab = 'settings'" 
                                    :class="activeTab === 'settings' ? 'tab-button-active' : 'tab-button-inactive'" 
                                    class="tab-button">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Ayarlar
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="mt-6 tab-content">
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#00c8b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Bilgileri
                    </h2>
                    @livewire('vitrin-editor')
                </div>
            </div>

            <div x-show="activeTab === 'analytics'" x-transition>
                @auth
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                        <h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#0099e5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Vitrin Analitikleri
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- Analytics Card 1 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-[#ebfaf8] text-[#00c8b3]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-gray-500 text-sm font-medium">Toplam Görüntülenme</h3>
                                        <p class="text-2xl font-semibold text-gray-900">{{ rand(100, 500) }}</p>
                                        <p class="text-green-600 text-sm">↑ %12 artış</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Analytics Card 2 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-[#e6f4fd] text-[#0099e5]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-gray-500 text-sm font-medium">Tıklamalar</h3>
                                        <p class="text-2xl font-semibold text-gray-900">{{ rand(30, 100) }}</p>
                                        <p class="text-green-600 text-sm">↑ %8 artış</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Analytics Card 3 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-[#ebfaf8] text-[#00c8b3]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-gray-500 text-sm font-medium">Ziyaretçiler</h3>
                                        <p class="text-2xl font-semibold text-gray-900">{{ rand(50, 200) }}</p>
                                        <p class="text-green-600 text-sm">↑ %15 artış</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Placeholder Chart -->
                        <div class="mt-4 bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="font-medium text-gray-700 mb-3">7 Günlük Ziyaretçi Grafiği</h3>
                            <div class="h-64 w-full bg-gray-50 rounded-lg p-4 flex items-center justify-center">
                                <div class="w-full">
                                    <div class="flex justify-between mb-2">
                                        <div class="text-xs text-gray-500">Pazartesi</div>
                                        <div class="text-xs text-gray-500">Çarşamba</div>
                                        <div class="text-xs text-gray-500">Cuma</div>
                                        <div class="text-xs text-gray-500">Pazar</div>
                                    </div>
                                    <div class="relative h-40">
                                        <div class="absolute bottom-0 w-full">
                                            <div class="flex h-40 items-end">
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-12"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-24"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-16"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-32"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-20"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-28"></div>
                                                </div>
                                                <div class="w-1/7 px-1">
                                                    <div class="bg-gradient-to-t from-[#00c8b3] to-[#0099e5] rounded-t h-36"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Analitik Verileri</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Analitik verilerini görmek için lütfen <a href="{{ route('login') }}" class="text-[#00c8b3] hover:underline">giriş yapın</a>.
                        </p>
                    </div>
                @endauth
            </div>

            <div x-show="activeTab === 'settings'" x-transition>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#00c8b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Ayarlar
                    </h2>
                    <p class="mt-3 text-gray-600">Hasta iletişim tercihleri ve bildirim ayarları gibi seçenekler yakında burada yer alacak.</p>
                    
                    <!-- Settings Cards -->
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-[#ebfaf8] text-[#00c8b3] mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">E-posta Bildirimleri</span>
                            </div>
                            <button class="px-4 py-2 bg-gray-100 text-gray-500 rounded-md cursor-not-allowed" disabled>Yönet (Yakında)</button>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-[#e6f4fd] text-[#0099e5] mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">SMS Bildirimleri</span>
                            </div>
                            <button class="px-4 py-2 bg-gray-100 text-gray-500 rounded-md cursor-not-allowed" disabled>Yönet (Yakında)</button>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-[#ebfaf8] text-[#00c8b3] mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">Gizlilik Ayarları</span>
                            </div>
                            <button class="px-4 py-2 bg-gray-100 text-gray-500 rounded-md cursor-not-allowed" disabled>Yönet (Yakında)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
