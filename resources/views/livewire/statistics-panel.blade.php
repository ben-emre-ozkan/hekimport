<div 
    class="bg-white rounded-lg shadow p-6 card-hover mb-8"
    wire:poll.{{ $pollingInterval }}ms="refreshStats"
>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-orbitron font-medium text-gray-900">Özet İstatistikler</h2>
        <button 
            class="text-blue-500 hover:text-blue-700 transition-colors flex items-center text-sm"
            wire:click="refreshStats"
            wire:loading.attr="disabled"
        >
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-4 w-4 mr-1 transition-transform" 
                wire:loading.class="animate-spin"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span wire:loading.class="text-gray-400">Yenile</span>
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4" x-data="{ hover: null }">
        <!-- Profile Views -->
        <div 
            class="bg-gray-50 p-4 rounded transition-all duration-300"
            x-on:mouseenter="hover = 'profile'"
            x-on:mouseleave="hover = null"
            x-bind:class="{ 'transform scale-105 shadow-md': hover === 'profile' }"
        >
            <div class="flex items-start">
                <div class="bg-blue-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Profil Görüntülenme</p>
                    <div class="flex items-end mt-1">
                        <p 
                            class="text-2xl font-bold text-gray-900"
                            wire:loading.class="animate-pulse"
                        >
                            {{ $profileViews }}
                        </p>
                        <span 
                            class="ml-1 text-xs text-green-600"
                            x-show="hover === 'profile'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            Son 30 gün
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Appointments -->
        <div 
            class="bg-gray-50 p-4 rounded transition-all duration-300"
            x-on:mouseenter="hover = 'appointments'"
            x-on:mouseleave="hover = null"
            x-bind:class="{ 'transform scale-105 shadow-md': hover === 'appointments' }"
        >
            <div class="flex items-start">
                <div class="bg-green-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Randevular</p>
                    <div class="flex items-end mt-1">
                        <p 
                            class="text-2xl font-bold text-gray-900"
                            wire:loading.class="animate-pulse"
                        >
                            {{ $appointments }}
                        </p>
                        <span 
                            class="ml-1 text-xs text-green-600"
                            x-show="hover === 'appointments'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Patients -->
        <div 
            class="bg-gray-50 p-4 rounded transition-all duration-300"
            x-on:mouseenter="hover = 'patients'"
            x-on:mouseleave="hover = null"
            x-bind:class="{ 'transform scale-105 shadow-md': hover === 'patients' }"
        >
            <div class="flex items-start">
                <div class="bg-purple-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Hastalar</p>
                    <div class="flex items-end mt-1">
                        <p 
                            class="text-2xl font-bold text-gray-900"
                            wire:loading.class="animate-pulse"
                        >
                            {{ $patients }}
                        </p>
                        <span 
                            class="ml-1 text-xs text-green-600"
                            x-show="hover === 'patients'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            Toplam
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div 
            class="bg-gray-50 p-4 rounded transition-all duration-300"
            x-on:mouseenter="hover = 'messages'"
            x-on:mouseleave="hover = null"
            x-bind:class="{ 'transform scale-105 shadow-md': hover === 'messages' }"
        >
            <div class="flex items-start">
                <div class="bg-yellow-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mesajlar</p>
                    <div class="flex items-end mt-1">
                        <p 
                            class="text-2xl font-bold text-gray-900"
                            wire:loading.class="animate-pulse"
                        >
                            {{ $messages }}
                        </p>
                        <span 
                            class="ml-1 text-xs text-yellow-600"
                            x-show="hover === 'messages'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            {{ $messages > 0 ? 'Okunmamış' : '' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div wire:loading wire:target="refreshStats" class="text-center text-xs text-gray-500 mt-4">
        İstatistikler yükleniyor...
    </div>
</div> 