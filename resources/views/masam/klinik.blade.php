<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta['title'] ?? 'Kliniğim - Hekimport' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? 'Klinik yönetim paneli' }}">
    
    <!-- Include Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Orbitron and Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-orbitron font-bold mb-6">Kliniğim</h1>
        
        <p class="text-gray-600 mb-8">Bu sayfa, klinik bilgilerinizi ve ayarlarınızı yönetmeniz içindir.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 card-hover">
                <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Klinik Bilgileri</h2>
                <p class="text-gray-600 mb-4">Kliniğinizin temel bilgilerini ekleyin ve düzenleyin.</p>
                <button class="inline-flex items-center px-4 py-2 btn-gradient text-white rounded-md">
                    Bilgileri Düzenle
                </button>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 card-hover">
                <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Çalışma Saatleri</h2>
                <p class="text-gray-600 mb-4">Kliniğinizin çalışma saatlerini ayarlayın.</p>
                <button class="inline-flex items-center px-4 py-2 btn-gradient text-white rounded-md">
                    Saatleri Düzenle
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 card-hover">
                <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Ekip Yönetimi</h2>
                <p class="text-gray-600 mb-4">Kliniğinizde çalışan hekimleri ve personeli yönetin.</p>
                <button class="inline-flex items-center px-4 py-2 btn-gradient text-white rounded-md">
                    Ekibi Yönet
                </button>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 card-hover">
                <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Randevu Ayarları</h2>
                <p class="text-gray-600 mb-4">Randevu alma kurallarını ve hatırlatıcıları ayarlayın.</p>
                <button class="inline-flex items-center px-4 py-2 btn-gradient text-white rounded-md">
                    Ayarları Düzenle
                </button>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 card-hover">
            <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Klinik Görünümü</h2>
            <p class="text-gray-600 mb-4">Kliniğinizin fotoğraflarını ve tanıtım bilgilerini ekleyin.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="border border-gray-200 rounded overflow-hidden">
                    <div class="h-32 bg-gray-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-3">
                        <p class="font-medium">Klinik Dış Görünüm</p>
                    </div>
                </div>
                <div class="border border-gray-200 rounded overflow-hidden">
                    <div class="h-32 bg-gray-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-3">
                        <p class="font-medium">Bekleme Salonu</p>
                    </div>
                </div>
                <div class="border border-gray-200 rounded overflow-hidden border-dashed">
                    <div class="h-32 bg-gray-100 flex items-center justify-center">
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-3 text-center">
                        <p class="font-medium text-gray-500">Fotoğraf Ekle</p>
                    </div>
                </div>
            </div>
        </div>
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
    
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 