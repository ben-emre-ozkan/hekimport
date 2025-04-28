<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Türkiye'nin en kapsamlı diş hekimi arama platformu. Şehir, uzmanlık ve isme göre diş hekimi bulun.">
        <meta name="keywords" content="diş hekimi, hekimport, dişçi ara, diş hekimi bul">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Hekimport - Modern Diş Hekimi Bulma Platformu</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            :root {
                --white: #FFFFFF;
                --light-green: #A7E5A0;
                --blue-green: #5BC0BE;
                --cyan: #00B8D4;
                --dark-green: #1B5E20;
                --dark-blue: #0277BD;
                --light-bg: #F0F4F1;
                
                /* Adding lighter teal/green tones */
                --turkuaz: #64E0D1; /* Lighter teal, no yellow tint */
                --turkuaz-hover: #4CD1C2;
                --turkuaz-light: #A3EEEA;
                --turkuaz-lighter: #D6F9F2;
                
                /* Button colors - slightly darker */
                --button-color: #32B6A8; /* Daha koyu bir turkuaz rengi */
                --button-hover: #2A9C91;
                
                /* Updating primary colors */
                --primary: var(--turkuaz);
                --primary-hover: var(--turkuaz-hover);
                --primary-light: var(--turkuaz-light);
                --secondary: var(--turkuaz-light);
                --secondary-hover: var(--turkuaz-hover);
                --accent-dark: var(--turkuaz);
                --text-dark: #2D3748;
                --text-medium: #4A5568;
                --text-light: #718096;
                --bg-light: var(--light-bg);
                --border-color: #E2E8F0;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                color: var(--text-medium);
                margin: 0;
                padding: 0;
                overflow-x: hidden;
                line-height: 1.6;
                background-color: var(--white);
            }
            
            h1, h2, h3, .font-heading {
                font-family: 'Poppins', sans-serif;
                color: var(--text-dark);
                font-weight: 600;
            }
            
            .font-orbitron {
                font-family: 'Orbitron', sans-serif;
            }
            
            #background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                background-color: var(--bg-light);
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2399f6e4' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }

            .hero-section {
                background-color: var(--turkuaz); 
                padding-top: 8rem;
                padding-bottom: 8rem;
                min-height: 70vh; /* Ensure minimum height */
                display: flex; /* Enable flexbox for alignment */
                align-items: center; /* Vertically center content */
                position: relative;
                overflow: hidden;
            }
                
                .hero-section h1 {
                    font-size: 1.5rem !important;
                    line-height: 1.2 !important;
                }
                
                .hero-section p {
                    font-size: 1rem !important;
                }
                
                /* Adjusting form layout for smaller screens */
                .hero-section .grid.grid-cols-1.md\:grid-cols-2 {
                    grid-template-columns: 1fr !important;
                    gap: 0.75rem !important;
                }
                
                /* Improve button spacing and sizing */
                .btn {
                    padding: 0.5rem 1rem;
                    font-size: 0.9rem;
                }
                
                /* Hide emoji decorations on very small screens */
                .hero-emoji {
                    display: none;
                }
                
                /* Fix header spacing */
                header {
                    padding: 0.75rem 0;
                }
                
                header .container {
                    padding: 0 1rem;
                }
                
                /* Reduce text size in navigation */
                header .nav-link, 
                header a.px-4.py-2 {
                    font-size: 0.85rem;
                    padding: 0.4rem 0.6rem;
                }

            /* Mobile-specific hero styles */
            @media (max-width: 767px) {
                .hero-section {
                    background-image: linear-gradient(to bottom, rgba(100, 224, 209, 0.9), rgba(100, 224, 209, 0.8)), url("{{ asset('img/hero-image.png') }}");
                    background-size: cover;
                    background-position: center;
                    background-blend-mode: overlay;
                    text-align: center;
                    padding-top: 6rem;
                    padding-bottom: 6rem;
                }
                
                .hero-section::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: radial-gradient(circle at center, transparent 0%, var(--turkuaz) 100%);
                    opacity: 0.6;
                    z-index: 1;
                }
                
                .hero-section .container {
                    position: relative;
                    z-index: 2;
                }
                
                .hero-section h1 {
                    font-size: 1.75rem !important;
                    line-height: 1.3 !important;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                
                .hero-section p {
                    font-size: 1.1rem !important;
                    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
                    margin-bottom: 1.5rem;
                }
                
                .hero-section .bg-white {
                    border-radius: 1rem;
                    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
                    border: 1px solid rgba(255,255,255,0.2);
                }
            }

            /* Extra small devices */
            @media (max-width: 480px) {
                /* Further reduce heading size */
                .hero-section h1 {
                    font-size: 1.25rem !important;
                }
                
                /* Compact search form */
                .hero-section .bg-white.p-4.sm\:p-6 {
                    padding: 1rem !important;
                }
                
                /* Make search form fields more compact */
                .hero-section select,
                .hero-section button {
                    height: 2.5rem;
                    min-height: 2.5rem;
                }
                
                /* Adjust all section paddings */
                section {
                    padding-top: 2rem;
                    padding-bottom: 2rem;
                }
                
                /* Make buttons more tappable */
                .btn, button[type="submit"] {
                    min-height: 2.75rem;
                }
                
                /* Mobile menu button layout */
                .mobile-menu-btn {
                    display: block;
                    width: 100%;
                    text-align: center;
                    padding: 0.75rem;
                    margin-bottom: 0.75rem;
                    border-radius: 0.5rem;
                    background-color: var(--bg-light);
                    color: var(--text-dark);
                    font-weight: 500;
                    font-size: 0.875rem;
                    transition: all 0.2s ease;
                }
                
                .mobile-menu-btn:hover {
                    background-color: #e5e7eb;
                }
                
                .mobile-menu-btn:last-child {
                    margin-bottom: 0;
                }
                
                /* Show mobile menu when active */
                .mobile-menu-container.active {
                    display: block !important;
                    position: fixed;
                    top: 56px;
                    left: 0;
                    width: 100%;
                    background-color: white;
                    padding: 1.25rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    z-index: 49;
                    border-bottom: 1px solid var(--border-color);
                }
            }

            /* Mobile menu styles */
            .mobile-menu-container {
                display: none;
            }
            
            .mobile-header-label {
                display: none;
            }

            /* Show mobile menu when active */
            .mobile-menu-container.active {
                display: block !important;
                position: fixed;
                top: 56px;
                left: 0;
                width: 100%;
                background-color: white;
                padding: 1.25rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                z-index: 50;
                border-bottom: 1px solid var(--border-color);
            }

            .mobile-menu-title {
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.75rem;
                font-size: 0.875rem;
                text-align: center;
            }

            .mobile-menu-btn {
                display: block;
                width: 100%;
                text-align: center;
                padding: 0.75rem;
                margin-bottom: 0.75rem;
                border-radius: 0.5rem;
                background-color: var(--bg-light);
                color: var(--text-dark);
                font-weight: 500;
                font-size: 0.875rem;
                transition: all 0.2s ease;
            }

            .mobile-menu-btn:hover {
                background-color: #e5e7eb;
            }

            .mobile-menu-btn:last-child {
                margin-bottom: 0;
            }

            .mobile-menu-btn[style*="background-color"] {
                color: white !important;
            }

            /* Header styles */
            header {
                background-color: white;
                border-bottom: 1px solid var(--border-color);
            }

            header .font-orbitron {
                color: var(--button-color) !important;
            }

            header .nav-link {
                color: var(--text-medium);
            }

            header .nav-link:hover {
                background-color: rgba(0, 200, 179, 0.1);
                color: var(--button-color);
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="background"></div>

        <!-- Header -->
        <header class="py-3 shadow-sm fixed w-full z-50">
            <div class="container mx-auto flex items-center justify-between px-4">
                <a href="/" class="flex items-center space-x-2">
                    <span class="font-orbitron text-xl md:text-2xl font-bold">HEKİMPORT</span>
                    <img src="{{ asset('img/favicon.png') }}" alt="Hekimport Favicon" class="block h-5 md:h-6 w-auto">
                </a>
                
                <div class="flex items-center">
                    <!-- Mobile Header Button - Removed -->
                    
                    <!-- Mobile Menu Toggle -->
                    <button id="mobileMenuToggle" class="mobile-menu-toggle md:hidden" aria-label="Toggle mobile menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                
                <div class="hidden md:flex items-center">
                     @if (Route::has('login'))
                        <nav class="flex items-center">
                            @auth
                                @if(Auth::user()->hasRole('Dentist'))
                                    <a href="{{ route('masa') }}" class="nav-link text-sm md:text-base">DT Paneli</a>
                                @else
                                    <a href="{{ url('/') }}" class="nav-link text-sm md:text-base">Hesabım</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="nav-link text-sm md:text-base">Çıkış Yap</button>
                                </form>
                            @else
                                <div class="flex items-center">
                                    <a href="{{ route('register') }}?type=doctor" class="text-sm hover:underline" style="color: var(--button-color);">
                                        Diş Hekimi misiniz?
                                    </a>
                                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-opacity-90 transition duration-200 ml-4" style="background-color: var(--button-color); color: white;">
                                        MASAM
                                    </a>
                                </div>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="mobile-menu-container">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->hasRole('Dentist'))
                            <a href="{{ route('masa') }}" class="mobile-menu-btn">DT Paneli</a>
                        @else
                            <a href="{{ url('/') }}" class="mobile-menu-btn">Hesabım</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="mobile-menu-btn">Çıkış Yap</button>
                        </form>
                    @else
                        <div class="mobile-menu-title">Diş hekimi misiniz?</div>
                        <a href="{{ route('login') }}" class="mobile-menu-btn" style="background-color: var(--button-color); color: white; margin-bottom: 0.75rem;">
                            MASAM
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}?type=doctor" class="mobile-menu-btn">
                                Diş Hekimi misiniz?
                            </a>
                        @endif
                    @endif
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="pt-20">
            <!-- Hero Section -->
            <section class="hero-section">
                {{-- Decorative Emojis --}}
                <span id="emoji-tooth" class="hero-emoji" aria-hidden="true">🦷</span>
                <span class="hero-emoji" style="top: 35%; right: 10%" aria-hidden="true">✨</span>
                <span class="hero-emoji" style="bottom: 25%; left: 20%" aria-hidden="true">⚕️</span> 
                {{-- End Decorative Emojis --}}
                
                <div class="container mx-auto px-4 md:px-6 flex flex-col md:flex-row items-center justify-between relative z-10">
                    <!-- Left Column: Heading, Tagline, Search Form -->
                    <div class="w-full md:w-1/2 lg:w-5/12 md:pr-6 mb-8 md:mb-0 md:text-left md:items-start">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-4 font-heading" style="color: white !important;">
                            Diş Hekiminizi <br class="hidden sm:block">Kolayca Bulun
                        </h1>
                        <p class="text-lg md:text-xl text-white mb-6 md:mb-8 opacity-90">Türkiye'nin en geniş diş hekimi ağına göz atın.</p>
                        
                        <!-- Doktor Arama Formu -->
                        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-xl w-full max-w-lg">
                            <form action="{{ route('doctor.search') }}" method="GET">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 items-stretch">
                                    <select id="specialty" name="specialty" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 text-sm md:text-base" style="--tw-ring-color: var(--primary); --tw-ring-opacity: 0.2; --tw-focus-ring-color: var(--primary);" aria-label="Diş Hekimliği Uzmanlığı">
                                        <option value="">Tüm Uzmanlıklar</option>
                                        <option value="Ağız, Diş ve Çene Cerrahisi">Ağız, Diş ve Çene Cerrahisi</option>
                                        <option value="Ağız, Diş ve Çene Radyolojisi">Ağız, Diş ve Çene Radyolojisi</option>
                                        <option value="Çocuk Diş Hekimliği">Çocuk Diş Hekimliği (Pedodonti)</option>
                                        <option value="Endodonti">Endodonti (Kanal Tedavisi)</option>
                                        <option value="Ortodonti">Ortodonti (Diş Teli)</option>
                                        <option value="Periodontoloji">Periodontoloji (Diş Eti Hastalıkları)</option>
                                        <option value="Protetik Diş Tedavisi">Protetik Diş Tedavisi (Protez)</option>
                                        <option value="Restoratif Diş Tedavisi">Restoratif Diş Tedavisi (Dolgu)</option>
                                        <option value="Diş Hekimliği (Genel)">Diş Hekimliği (Genel)</option>
                                    </select>
                                    
                                    <select id="city" name="city" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 text-sm md:text-base" style="--tw-ring-color: var(--primary); --tw-ring-opacity: 0.2; --tw-focus-ring-color: var(--primary);" aria-label="Şehir">
                                        <option value="">Tüm Şehirler</option>
                                        {{-- 81 il buraya eklenecek --}}
                                        <option value="Adana">Adana</option>
                                        <option value="Adıyaman">Adıyaman</option>
                                        <option value="Afyonkarahisar">Afyonkarahisar</option>
                                        <option value="Ağrı">Ağrı</option>
                                        <option value="Amasya">Amasya</option>
                                        <option value="Ankara">Ankara</option>
                                        <option value="Antalya">Antalya</option>
                                        <option value="Artvin">Artvin</option>
                                        <option value="Aydın">Aydın</option>
                                        <option value="Balıkesir">Balıkesir</option>
                                        <option value="Bilecik">Bilecik</option>
                                        <option value="Bingöl">Bingöl</option>
                                        <option value="Bitlis">Bitlis</option>
                                        <option value="Bolu">Bolu</option>
                                        <option value="Burdur">Burdur</option>
                                        <option value="Bursa">Bursa</option>
                                        <option value="Çanakkale">Çanakkale</option>
                                        <option value="Çankırı">Çankırı</option>
                                        <option value="Çorum">Çorum</option>
                                        <option value="Denizli">Denizli</option>
                                        <option value="Diyarbakır">Diyarbakır</option>
                                        <option value="Edirne">Edirne</option>
                                        <option value="Elazığ">Elazığ</option>
                                        <option value="Erzincan">Erzincan</option>
                                        <option value="Erzurum">Erzurum</option>
                                        <option value="Eskişehir">Eskişehir</option>
                                        <option value="Gaziantep">Gaziantep</option>
                                        <option value="Giresun">Giresun</option>
                                        <option value="Gümüşhane">Gümüşhane</option>
                                        <option value="Hakkari">Hakkari</option>
                                        <option value="Hatay">Hatay</option>
                                        <option value="Isparta">Isparta</option>
                                        <option value="Mersin">Mersin</option>
                                        <option value="İstanbul">İstanbul</option>
                                        <option value="İzmir">İzmir</option>
                                        <option value="Kars">Kars</option>
                                        <option value="Kastamonu">Kastamonu</option>
                                        <option value="Kayseri">Kayseri</option>
                                        <option value="Kırklareli">Kırklareli</option>
                                        <option value="Kırşehir">Kırşehir</option>
                                        <option value="Kocaeli">Kocaeli</option>
                                        <option value="Konya">Konya</option>
                                        <option value="Kütahya">Kütahya</option>
                                        <option value="Malatya">Malatya</option>
                                        <option value="Manisa">Manisa</option>
                                        <option value="Kahramanmaraş">Kahramanmaraş</option>
                                        <option value="Mardin">Mardin</option>
                                        <option value="Muğla">Muğla</option>
                                        <option value="Muş">Muş</option>
                                        <option value="Nevşehir">Nevşehir</option>
                                        <option value="Niğde">Niğde</option>
                                        <option value="Ordu">Ordu</option>
                                        <option value="Rize">Rize</option>
                                        <option value="Sakarya">Sakarya</option>
                                        <option value="Samsun">Samsun</option>
                                        <option value="Siirt">Siirt</option>
                                        <option value="Sinop">Sinop</option>
                                        <option value="Sivas">Sivas</option>
                                        <option value="Tekirdağ">Tekirdağ</option>
                                        <option value="Tokat">Tokat</option>
                                        <option value="Trabzon">Trabzon</option>
                                        <option value="Tunceli">Tunceli</option>
                                        <option value="Şanlıurfa">Şanlıurfa</option>
                                        <option value="Uşak">Uşak</option>
                                        <option value="Van">Van</option>
                                        <option value="Yozgat">Yozgat</option>
                                        <option value="Zonguldak">Zonguldak</option>
                                        <option value="Aksaray">Aksaray</option>
                                        <option value="Bayburt">Bayburt</option>
                                        <option value="Karaman">Karaman</option>
                                        <option value="Kırıkkale">Kırıkkale</option>
                                        <option value="Batman">Batman</option>
                                        <option value="Şırnak">Şırnak</option>
                                        <option value="Bartın">Bartın</option>
                                        <option value="Ardahan">Ardahan</option>
                                        <option value="Iğdır">Iğdır</option>
                                        <option value="Yalova">Yalova</option>
                                        <option value="Karabük">Karabük</option>
                                        <option value="Kilis">Kilis</option>
                                        <option value="Osmaniye">Osmaniye</option>
                                        <option value="Düzce">Düzce</option>
                                    </select>

                                    <button type="submit" class="btn text-base md:text-lg py-2 md:py-3 inline-flex items-center justify-center hover:bg-opacity-90 transition duration-200 h-full" style="background-color: var(--button-color); color: white;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1 md:mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="whitespace-nowrap">Diş Hekimi Ara</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Right Column: Illustration -->
                    <div class="w-full md:w-1/2 lg:w-7/12 md:pl-6 flex justify-center md:justify-end items-center hidden md:flex">
                        <img src="{{ asset('img/hero-image.png') }}" 
                             alt="Diş hekimleri ve hastalar" 
                             class="w-full h-auto object-contain max-w-xl">
                    </div>
                </div>
            </section>

            <!-- Öne Çıkan Doktorlar -->
            <section class="py-16 md:py-24 bg-white">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 md:mb-16 font-heading">Öne Çıkan Diş Hekimlerimiz</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                        @forelse($doctors as $doctor)
                        <div class="doctor-card">
                            <div class="p-5">
                                <div class="flex items-center justify-center mb-5">
                                    @if($doctor->profile_image)
                                        <img src="{{ asset('storage/' . $doctor->profile_image) }}" alt="{{ $doctor->name }}" class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4" style="border-color: var(--turkuaz-lighter);">
                                    @else
                                        <div class="w-28 h-28 md:w-32 md:h-32 rounded-full flex items-center justify-center border-4" style="background-color: var(--light-bg); border-color: var(--turkuaz-lighter);">
                                            <span class="text-2xl font-bold" style="color: var(--turkuaz);">DT</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="text-lg md:text-xl font-semibold text-center mb-1 font-heading">Dt. {{ $doctor->name }}</h3>
                                <p class="text-gray-600 text-center text-sm mb-5">{{ $doctor->specialty }}</p>
                                <div class="flex justify-center">
                                    <a href="{{ route('doctor.public-profile', $doctor) }}" class="btn btn-primary text-sm px-4 py-2">
                                        {{ __('Profili Görüntüle') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="col-span-full text-center text-gray-500">Henüz öne çıkan diş hekimi bulunmamaktadır.</p>
                        @endforelse
                    </div>
                    
                    @if($doctors->isNotEmpty())
                    <div class="text-center mt-12 md:mt-16">
                        <a href="{{ route('doctor.search') }}" class="inline-flex items-center font-semibold group text-base md:text-lg" style="color: var(--turkuaz);">
                            {{ __('Tüm diş hekimlerini görüntüle') }}
                            <svg class="w-4 h-4 md:w-5 md:h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </section>
            
            <!-- Neden Biz Section -->
            <section class="py-16 md:py-24 features-section border-t border-gray-200">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 md:mb-16 font-heading">Neden Hekimport?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-white p-8 rounded-xl shadow-md transform transition duration-300 hover:scale-105 border border-gray-100">
                            <div class="text-4xl mb-5" style="color: var(--light-green);">✅</div>
                            <h3 class="text-xl md:text-2xl font-semibold mb-3 font-heading">Doğrulanmış Hekimler</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">Platformumuzdaki tüm diş hekimleri, diplomaları ve uzmanlıkları kontrol edilerek doğrulanmıştır.</p>
                        </div>
                        
                        <div class="bg-white p-8 rounded-xl shadow-md transform transition duration-300 hover:scale-105 border border-gray-100">
                            <div class="text-4xl mb-5" style="color: var(--turkuaz);">⏱️</div>
                            <h3 class="text-xl md:text-2xl font-semibold mb-3 font-heading">Kolay Randevu</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">Birkaç tıklama ile size en uygun diş hekimi bulun ve randevunuzu anında online olarak oluşturun.</p>
                        </div>
                        
                        <div class="bg-white p-8 rounded-xl shadow-md transform transition duration-300 hover:scale-105 border border-gray-100">
                            <div class="text-4xl mb-5" style="color: var(--turkuaz);">🔍</div>
                            <h3 class="text-xl md:text-2xl font-semibold mb-3 font-heading">Detaylı Arama</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">Şehir, uzmanlık alanı gibi kriterlere göre arama yaparak ihtiyacınıza en uygun hekimi kolayca bulun.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="text-gray-300 py-12" style="background-color: var(--turkuaz);">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <a href="/" class="flex items-center mb-4">
                            <h2 class="font-orbitron text-2xl font-bold text-white">HEKİMPORT</h2>
                        </a>
                        <p class="text-sm text-white opacity-90 mb-4">Diş Sağlığınıza Açılan Modern Kapı</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4 font-heading">Hızlı Bağlantılar</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">Hakkımızda</a></li>
                            <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">Gizlilik Politikası</a></li>
                            <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">Kullanım Şartları</a></li>
                            <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">İletişim</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4 font-heading">İletişim</h3>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                info@hekimport.com
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                +90 (212) 123 45 67
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-white border-opacity-20 mt-10 pt-8 text-center text-sm text-white opacity-90">
                    <p>&copy; {{ date('Y') }} Hekimport. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </footer>

        <!-- Add JavaScript for mobile menu toggle -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuToggle = document.getElementById('mobileMenuToggle');
                const mobileMenu = document.getElementById('mobileMenu');
                
                if (mobileMenuToggle && mobileMenu) {
                    mobileMenuToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        mobileMenu.classList.toggle('active');
                    });
                    
                    // Close menu when clicking outside
                    document.addEventListener('click', function(event) {
                        const isClickInside = mobileMenu.contains(event.target) || mobileMenuToggle.contains(event.target);
                        if (!isClickInside && mobileMenu.classList.contains('active')) {
                            mobileMenu.classList.remove('active');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
