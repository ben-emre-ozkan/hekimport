<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- SEO Meta Tags --}}
        <title>{{ isset($meta['title']) ? $meta['title'] : __('Forum - Hekimport') }}</title>
        <meta name="description" content="{{ isset($meta['description']) ? $meta['description'] : __('Diş hekimleri için forum ve tartışma platformu.') }}">
        <meta name="keywords" content="{{ isset($meta['keywords']) ? $meta['keywords'] : __('forum, diş hekimi, tartışma, hekimport') }}">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ isset($meta['title']) ? $meta['title'] : __('Forum - Hekimport') }}">
        <meta property="og:description" content="{{ isset($meta['description']) ? $meta['description'] : __('Diş hekimleri için forum ve tartışma platformu.') }}">
        <meta property="og:image" content="@yield('og:image', asset('img/hekimport-og-image.png'))">

        {{-- Twitter --}}
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ isset($meta['title']) ? $meta['title'] : __('Forum - Hekimport') }}">
        <meta property="twitter:description" content="{{ isset($meta['description']) ? $meta['description'] : __('Diş hekimleri için forum ve tartışma platformu.') }}">
        <meta property="twitter:image" content="@yield('og:image', asset('img/hekimport-og-image.png'))">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <style>
            /* Forum-specific styles */
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }
            
            .forum-header {
                background: linear-gradient(135deg, #00c8b3 0%, #0099e5 100%);
                color: white;
                padding: 1.5rem 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }
            
            .forum-content {
                padding: 2rem 0;
            }
            
            .forum-card {
                border-radius: 0.75rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                border: none;
            }
            
            .topic-row {
                transition: all 0.2s ease;
            }
            
            .topic-row:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }
            
            .forum-btn {
                background: linear-gradient(135deg, #00c8b3 0%, #0099e5 100%);
                color: white;
                transition: all 0.3s ease;
            }
            
            .forum-btn:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }
            
            .user-avatar {
                border: 2px solid #e5e7eb;
            }
            
            /* Modern scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #00c8b3, #0099e5);
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #00b5a3, #0088d4);
            }
            
            /* Forum topic list styles */
            .forum-topic-list {
                list-style: none;
                padding: 0;
            }
            
            .forum-topic-item {
                border-left: 3px solid transparent;
                transition: all 0.2s ease;
            }
            
            .forum-topic-item:hover, .forum-topic-item.active {
                border-left-color: #00c8b3;
                background-color: rgba(0, 200, 179, 0.05);
            }
            
            /* Three column layout */
            .forum-container {
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
                gap: 1.5rem;
                max-width: 1400px;
                margin: 0 auto;
            }
            
            /* Left column - Categories & Topics */
            .forum-left-column {
                position: sticky;
                top: 1rem;
                align-self: start;
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
                padding-right: 0.5rem;
            }
            
            /* Middle column - Selected Topic Content */
            .forum-middle-column {
                overflow: hidden;
            }
            
            /* Right column - Admin Content */
            .forum-right-column {
                position: sticky;
                top: 1rem;
                align-self: start;
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
                padding-left: 0.5rem;
            }
            
            /* Responsive adjustments */
            @media (max-width: 1279px) {
                .forum-container {
                    grid-template-columns: 1fr 2fr;
                }
                
                .forum-right-column {
                    display: none;
                }
            }
            
            @media (max-width: 1023px) {
                .forum-container {
                    grid-template-columns: 1fr;
                }
                
                .forum-left-column,
                .forum-middle-column,
                .forum-right-column {
                    position: static;
                    max-height: none;
                    overflow-y: visible;
                    padding: 0;
                }
                
                .forum-left-column {
                    order: 2;
                }
                
                .forum-middle-column {
                    order: 1;
                }
            }
            
            /* Fix for Alpine.js issue */
            [x-cloak] { 
                display: none !important; 
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <!-- Forum Header -->
            <header class="forum-header">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <a href="{{ route('forum.index') }}" class="flex items-center group">
                                <img src="{{ asset('img/favicon.png') }}" alt="Hekimport" class="h-10 w-auto mr-3 transform group-hover:scale-110 transition">
                                <h1 class="text-2xl font-bold font-orbitron">Hekimport Forum</h1>
                            </a>
                        </div>
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 flex items-center transition">
                                <i class="fas fa-home mr-2"></i> {{ __('Ana Sayfa') }}
                            </a>
                            @auth
                                <a href="{{ route('profile.show') }}" class="text-white hover:text-gray-200 flex items-center transition">
                                    <i class="fas fa-user mr-2"></i> {{ Auth::user()->name }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="forum-content">
                {{ $slot }}
            </main>

            <!-- Forum Footer -->
            <footer class="bg-white py-8 border-t border-gray-200">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('img/favicon.png') }}" alt="Hekimport" class="h-6 w-auto mr-2">
                                <p class="text-gray-700 font-medium">Hekimport Forum</p>
                            </div>
                            <p class="text-gray-500">&copy; {{ date('Y') }} Hekimport. {{ __('Tüm hakları saklıdır.') }}</p>
                        </div>
                        <div class="flex flex-wrap justify-center space-x-6">
                            <a href="{{ route('forum.index') }}" class="text-gray-600 hover:text-[#00c8b3] transition">
                                <i class="fas fa-home mr-1"></i> {{ __('Forum Ana Sayfa') }}
                            </a>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-[#00c8b3] transition">
                                <i class="fas fa-tachometer-alt mr-1"></i> {{ __('Hekimport Ana Sayfa') }}
                            </a>
                            <a href="#" class="text-gray-600 hover:text-[#00c8b3] transition">
                                <i class="fas fa-book mr-1"></i> {{ __('Forum Kuralları') }}
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @livewireScripts
        <script>
            // Fix for Alpine.js multiple instances issue
            document.addEventListener('livewire:navigating', () => {
                if (window.Alpine) {
                    document.querySelectorAll('[x-data]').forEach(el => {
                        if (el.__x) {
                            el.__x.destroy();
                        }
                    });
                }
            });
            
            // Ensure Alpine elements are properly cleaned up during Livewire updates
            document.addEventListener('livewire:load', () => {
                Livewire.hook('message.processed', (message, component) => {
                    if (window.Alpine) {
                        // Small delay to ensure the DOM is updated
                        setTimeout(() => {
                            // Force Alpine to reinitialize elements
                            window.Alpine.initTree(document.body);
                        }, 10);
                    }
                });
            });
            
            // Preserve scroll position after Livewire refreshes
            let scrollPositions = {};
            
            document.addEventListener('livewire:load', () => {
                Livewire.hook('message.sent', (message, component) => {
                    if (document.activeElement && document.activeElement.tagName === 'TEXTAREA') {
                        const id = document.activeElement.id;
                        if (id) {
                            scrollPositions[id] = document.activeElement.scrollTop;
                        }
                    }
                });
                
                Livewire.hook('message.processed', (message, component) => {
                    for (const [id, position] of Object.entries(scrollPositions)) {
                        const element = document.getElementById(id);
                        if (element && element.tagName === 'TEXTAREA') {
                            element.scrollTop = position;
                        }
                    }
                });
            });
        </script>
    </body>
</html> 