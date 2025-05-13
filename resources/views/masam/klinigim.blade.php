<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta['title'] ?? 'Kliniğim - Hekimport' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? 'Klinik yönetim merkezi' }}">
    <meta name="keywords" content="{{ $meta['keywords'] ?? 'klinik, yönetim, hekimport' }}">
    
    <!-- Include Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Orbitron and Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
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
        /* Hide Alpine elements before initialization */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="gradient-primary text-white py-6">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-orbitron font-bold">🦷 Masam</h1>
                </div>
                <div>
                    <div class="flex items-center space-x-4">
                        <span>{{ auth()->user()->name }}</span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 bg-white">
            <div class="container mx-auto px-4">
                <nav class="flex space-x-8">
                    <a href="{{ route('masam') }}" class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Dashboard
                    </a>
                    <a href="{{ route('vitrinim') }}" class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Vitrinim
                    </a>
                    <a href="{{ route('klinik') }}" class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Klinik
                    </a>
                    <a href="{{ route('klinigim') }}" class="py-4 px-1 border-b-2 border-blue-500 text-sm font-medium text-blue-600">
                        Kliniğim
                    </a>
                </nav>
            </div>
        </div>
        
        @livewire('klinigim-page')
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p>&copy; {{ date('Y') }} Hekimport. Tüm hakları saklıdır.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white">Gizlilik Politikası</a>
                    <a href="#" class="text-gray-300 hover:text-white">Kullanım Şartları</a>
                    <a href="#" class="text-gray-300 hover:text-white">Yardım</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 