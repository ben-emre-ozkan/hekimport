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

    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-orbitron font-bold mb-6">Vitrinim Yönetimi</h1>
            
            <!-- Feedback messages -->
            @if($message)
                <div class="mb-6 p-4 rounded-md {{ $messageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
                    {{ $message }}
                </div>
            @endif
            
            <!-- Tab navigation -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex -mb-px space-x-8">
                    <button wire:click="setTab('profile')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Profil Bilgileri
                    </button>
                    <button wire:click="setTab('slots')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'slots' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Çalışma Saatleri
                    </button>
                    <button wire:click="setTab('services')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'services' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Hizmetler
                    </button>
                    <button wire:click="setTab('seo')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'seo' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        SEO ve Görünüm
                    </button>
                    <button wire:click="setTab('analytics')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'analytics' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Analizler
                    </button>
                </nav>
            </div>
            
            <!-- Tab content -->
            <div class="bg-white rounded-lg shadow-md">
                <!-- Profile Tab -->
                <div class="p-6" x-data="{ showProfileSection: true }" x-show="'{{ $tab }}' === 'profile'">
                    @include('livewire.vitrinim-tabs.profile-tab')
                </div>
                
                <!-- Slots Tab -->
                <div class="p-6" x-data="{ showSlotsSection: true }" x-show="'{{ $tab }}' === 'slots'">
                    @include('livewire.vitrinim-tabs.slots-tab')
                </div>
                
                <!-- Services Tab -->
                <div class="p-6" x-data="{ showServicesSection: true }" x-show="'{{ $tab }}' === 'services'">
                    @include('livewire.vitrinim-tabs.services-tab')
                </div>
                
                <!-- SEO Tab -->
                <div class="p-6" x-data="{ showSeoSection: true }" x-show="'{{ $tab }}' === 'seo'">
                    @include('livewire.vitrinim-tabs.seo-tab')
                </div>
                
                <!-- Analytics Tab -->
                <div x-show="'{{ $tab }}' === 'analytics'">
                    <livewire:vitrin-analytics-dashboard :vitrin="$vitrin" />
                </div>
            </div>
            
            <!-- Preview Section (Not shown in Analytics tab) -->
            <div class="mt-8" x-show="'{{ $tab }}' !== 'analytics'">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-medium text-gray-900 mb-4">Vitrin Önizleme</h2>
                    <p class="text-gray-600 mb-4">Profilinizi nasıl görüneceğini önizleyin ve yayınlayın.</p>
                    <div class="flex space-x-4">
                        <a href="/vitrin/preview/{{ auth()->id() }}" 
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Önizleme
                        </a>
                        <button 
                            wire:click="toggleVisibility"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium {{ $is_active ? 'text-red-700 bg-red-50 hover:bg-red-100' : 'text-green-700 bg-green-50 hover:bg-green-100' }}">
                            @if($is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                                Vitrinimi Gizle
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Vitrinimi Yayınla
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
