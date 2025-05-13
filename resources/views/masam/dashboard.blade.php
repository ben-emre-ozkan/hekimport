<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diş Hekimi Paneli - Hekimport</title>
    <meta name="description" content="Diş hekimleri için yönetim paneli">
    
    <!-- Include Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Orbitron and Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Custom styles for gradient and other design elements -->
    <style>
        .font-orbitron {
            font-family: 'Orbitron', sans-serif;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #00c8b3 0%, #0099e5 100%);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #00c8b3 0%, #0099e5 100%);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 153, 229, 0.1), 0 4px 6px -2px rgba(0, 153, 229, 0.05);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Special animation effects for cards */
        .menu-card {
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 200, 179, 0.1) 0%, rgba(0, 153, 229, 0.1) 100%);
            transform: translateY(100%);
            transition: transform 0.5s ease;
            z-index: 0;
        }
        .menu-card:hover::before {
            transform: translateY(0);
        }
        
        /* Hide Alpine elements before initialization */
        [x-cloak] { display: none !important; }
        
        /* New dashboard styles */
        .sidebar {
            width: 260px;
            transition: all 0.3s ease;
        }
        .sidebar-collapsed {
            width: 80px;
        }
        .main-content {
            transition: all 0.3s ease;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div 
            :class="{'sidebar': sidebarOpen, 'sidebar-collapsed': !sidebarOpen}" 
            class="sidebar bg-white shadow-md z-10 flex flex-col">
            <!-- Logo Area -->
            <div class="flex items-center justify-between p-4" :class="{'justify-center': !sidebarOpen}">
                <a href="{{ route('masam') }}" class="flex items-center space-x-2" :class="{'space-x-0': !sidebarOpen}">
                    <div class="gradient-primary rounded-lg p-1 flex items-center justify-center w-10 h-10">
                        <span class="text-white font-orbitron font-bold text-xl">H</span>
                    </div>
                    <span x-show="sidebarOpen" class="font-orbitron text-gray-900 font-bold text-lg">Hekimport</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            
            <!-- Sidebar Menu -->
            <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
                <div class="space-y-1 px-3">
                    <!-- Dashboard Link -->
                    <a href="{{ route('masam') }}" class="flex items-center space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100 bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarOpen">Masam</span>
                    </a>
                    
                    <!-- Vitrinim Link with Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                            class="w-full flex items-center justify-between space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span x-show="sidebarOpen">Vitrinim</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor"
                                :class="{ 'transform rotate-180': open }">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 transform -translate-y-2" 
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             x-cloak
                            class="mt-1 ml-12 space-y-1" x-show="sidebarOpen">
                            <a href="{{ route('vitrinim') }}" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-teal-600 transition-colors duration-200 text-sm">
                                <span>Profili Düzenle</span>
                            </a>
                            <a href="{{ route('vitrinim') }}?tab=services" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-teal-600 transition-colors duration-200 text-sm">
                                <span>Hizmetleri Yönet</span>
                            </a>
                            <a href="{{ route('vitrinim') }}?tab=appointments" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-teal-600 transition-colors duration-200 text-sm">
                                <span>Randevu Slotları</span>
                            </a>
                            <a href="{{ route('vitrinim') }}?tab=analytics" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-teal-600 transition-colors duration-200 text-sm">
                                <span>Analitik Görüntüle</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Kliniğim Link with Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                            class="w-full flex items-center justify-between space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span x-show="sidebarOpen">Kliniğim</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor"
                                :class="{ 'transform rotate-180': open }">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 transform -translate-y-2" 
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             x-cloak
                            class="mt-1 ml-12 space-y-1" x-show="sidebarOpen">
                            <a href="{{ url('/masam/klinik') }}?tab=edit" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200 text-sm">
                                <span>Klinik Bilgilerini Düzenle</span>
                            </a>
                            <a href="{{ url('/masam/klinik') }}?tab=staff" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200 text-sm">
                                <span>Personel Yönetimi</span>
                            </a>
                            <a href="{{ url('/masam/klinik') }}?tab=equipment" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200 text-sm">
                                <span>Ekipman Envanteri</span>
                            </a>
                            <a href="{{ url('/masam/klinik') }}?tab=hours" class="flex items-center space-x-3 rounded-lg py-2 px-3 text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200 text-sm">
                                <span>Çalışma Saatleri</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p x-show="sidebarOpen" class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Diğer
                        </p>
                        
                        <!-- Quick Message Link -->
                        <a href="mailto:support@hekimport.com?subject=Hekimport%20Panelinden%20Mesaj" class="mt-1 flex items-center space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100 hover:text-yellow-600 transition-colors duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 group-hover:text-yellow-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span x-show="sidebarOpen" class="transition-all duration-200">Hekimport Ekibine Hızlı Mesaj</span>
                        </a>
                        
                        <!-- Settings Link -->
                        <a href="{{ route('profile.show') }}" class="mt-1 flex items-center space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen">Ayarlar</span>
                        </a>
                        
                        <!-- Logout Link -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 rounded-lg py-3 px-3 text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span x-show="sidebarOpen">Çıkış Yap</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div :class="{'pl-[260px]': sidebarOpen, 'pl-[80px]': !sidebarOpen}" class="flex-1 overflow-auto main-content">
            <!-- Top Header -->
            <header class="bg-white shadow-sm py-4 px-6 flex items-center justify-between">
                <!-- Mobile Menu Toggle Button (visible only on mobile) -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <h1 class="text-xl font-medium text-gray-800 hidden md:block">Diş Hekimi Paneli</h1>
                <!-- Show Hekimport logo on mobile -->
                <div class="md:hidden flex items-center">
                    <div class="gradient-primary rounded-lg p-1 flex items-center justify-center w-8 h-8">
                        <span class="text-white font-orbitron font-bold text-lg">H</span>
                    </div>
                    <span class="font-orbitron text-gray-900 font-bold text-lg ml-2">Hekimport</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications Dropdown -->
                    @livewire('notifications-dropdown')
                    
                    <!-- User Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            @if(auth()->user()->getFirstMediaUrl('profile_photos'))
                                <img src="{{ auth()->user()->getFirstMediaUrl('profile_photos') }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover border-2 border-blue-500">
                            @elseif(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover border-2 border-blue-500">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-teal-500 to-blue-500 flex items-center justify-center border-2 border-blue-500 text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700 hidden md:inline-block">{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="{{ route('vitrinim') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Vitrinim</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış Yap</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                <!-- Welcome Message -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 overflow-hidden relative">
                    <div class="flex items-center justify-between">
                        <div class="max-w-[70%] z-10">
                            <h2 class="text-2xl font-medium text-gray-900">Hoş geldiniz, {{ auth()->user()->name }}</h2>
                            <p class="text-gray-600 mt-1">Hekimport paneline hoş geldiniz. Profilinizi güncelleyebilir ve uygulamaları kullanabilirsiniz.</p>
                        </div>
                        <div class="z-10">
                            @if(file_exists(public_path('img/dentist-illustration.svg')))
                                <img src="{{ asset('img/dentist-illustration.svg') }}" alt="Diş Hekimi İllüstrasyonu" class="h-24 w-auto">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center text-white font-bold text-4xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-teal-100 to-blue-100 rounded-full -mr-20 -mt-20 opacity-20"></div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Profil Görüntülenme -->
                    <div class="bg-white rounded-lg shadow-sm p-4 relative overflow-hidden stat-card border-l-4 border-blue-500">
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-blue-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium uppercase text-gray-600">Profil Görüntülenme</p>
                        <h3 class="text-3xl font-bold mt-2 text-blue-600">247</h3>
                        <p class="text-sm mt-1 text-gray-600">Son 30 günde <span class="font-medium text-blue-600">↑12%</span></p>
                    </div>
                    
                    <!-- Randevu Talepleri -->
                    <div class="bg-white rounded-lg shadow-sm p-4 relative overflow-hidden stat-card border-l-4 border-green-500">
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-green-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium uppercase text-gray-600">Randevu Talepleri</p>
                        <h3 class="text-3xl font-bold mt-2 text-green-600">18</h3>
                        <p class="text-sm mt-1 text-gray-600">Bu ay <span class="font-medium text-green-600">↑5%</span></p>
                    </div>
                    
                    <!-- Mesajlar -->
                    <div class="bg-white rounded-lg shadow-sm p-4 relative overflow-hidden stat-card border-l-4 border-purple-500">
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-purple-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium uppercase text-gray-600">Mesajlar</p>
                        <h3 class="text-3xl font-bold mt-2 text-purple-600">5</h3>
                        <p class="text-sm mt-1 text-gray-600">Okunmamış <span class="font-medium text-purple-600">3 yeni</span></p>
                    </div>
                    
                    <!-- Toplam Puan -->
                    <div class="bg-white rounded-lg shadow-sm p-4 relative overflow-hidden stat-card border-l-4 border-amber-500">
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-amber-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium uppercase text-gray-600">Toplam Puan</p>
                        <h3 class="text-3xl font-bold mt-2 text-amber-600">4.8</h3>
                        <p class="text-sm mt-1 text-gray-600">Hasta değerlendirmesi <span class="font-medium text-amber-600">↑0.2</span></p>
                    </div>
                </div>
                
                <!-- Main Dashboard Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Vitrinim Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-teal-500 to-blue-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.profile-completion-card')
                        </div>
                    </div>
                    
                    <!-- Kliniğim Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.clinic-summary-card')
                        </div>
                    </div>
                    
                    <!-- Harita Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.clinic-map-card')
                        </div>
                    </div>
                    
                    <!-- Appointment Stats Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.appointment-stats-card')
                        </div>
                    </div>
                    
                    <!-- Profile Views Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-sky-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.profile-views-card')
                        </div>
                    </div>
                    
                    <!-- Quick Access Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-2 bg-gradient-to-r from-gray-500 to-gray-700"></div>
                        <div class="p-6">
                            @livewire('dashboard.quick-access-card')
                        </div>
                    </div>
                </div>
                
                <!-- Visitor Map and Recent Activity Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Visitor Map Card -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 lg:col-span-1">
                        <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="p-6">
                            @livewire('dashboard.clinic-visitor-map-card')
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-all duration-300 lg:col-span-2">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Son Aktiviteler</h3>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">Tümünü Gör</a>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                <div class="bg-blue-100 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-900">Giriş yapıldı</p>
                                        <span class="text-sm text-gray-500">{{ now()->subHours(1)->format('H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ now()->subHours(1)->format('d.m.Y') }} tarihinde sisteme giriş yaptınız.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                <div class="bg-green-100 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-900">Profil görüntülendi</p>
                                        <span class="text-sm text-gray-500">{{ now()->subHours(3)->format('H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Profiliniz {{ now()->subHours(3)->format('d.m.Y') }} tarihinde 5 kez görüntülendi.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                <div class="bg-amber-100 rounded-full p-2 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900">Yeni randevu talebi</p>
                                        <span class="text-sm text-gray-500">{{ now()->subDay()->format('H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Ahmet Yılmaz adlı hasta randevu talebinde bulundu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
            <footer class="py-6 px-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row md:justify-between items-center">
                    <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Hekimport. Tüm hakları saklıdır.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Gizlilik Politikası</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Kullanım Şartları</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Yardım</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 