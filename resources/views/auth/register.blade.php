<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="Hekimport - Diş Hekimi Kaydı">
    <meta name="description" content="Hekimport'a kaydolun ve diş hekimi vitrininizi oluşturun.">
    <meta name="keywords" content="hekimport, diş hekimi kayıt, dişçi platformu, diş hekimi">

    <title>Diş Hekimi Kaydı | Hekimport</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #4ade80; /* Lighter green */
            --primary-hover: #22c55e;
            --primary-light: #bbf7d0;
            --secondary: #0ea5e9; /* Lighter blue */
            --secondary-hover: #0284c7;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            background-size: 400%;
            animation: gradientFlow 15s ease infinite;
        }
        
        .btn-gradient {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: transform 0.2s ease, background 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: scale(1.05);
            background: linear-gradient(to right, var(--primary-hover), var(--secondary-hover));
        }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="bg-white py-4 px-6 shadow-sm fixed w-full z-50 border-b border-gray-200">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center">
                <h1 class="font-orbitron text-2xl text-green-500 font-bold">HEKİMPORT</h1>
            </a>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2 rounded-lg bg-green-500 text-white font-medium hover:bg-green-600 transition duration-200">
                    MASAM
                </a>
            </div>
        </div>
    </header>

    <div class="min-h-screen gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 pt-32">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full card-hover">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/favicon.png') }}" alt="Hekimport Logo" class="h-16 w-auto">
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Diş Hekimi Kaydı</h2>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="dentist">

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm transition-all duration-200
                        focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50
                        @error('name') border-red-500 bg-red-50 @enderror"
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-posta Adresi</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="username" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm transition-all duration-200
                        focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50
                        @error('email') border-red-500 bg-red-50 @enderror"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Şifre</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm transition-all duration-200
                        focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50
                        @error('password') border-red-500 bg-red-50 @enderror"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Şifre Tekrarı</label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm transition-all duration-200
                        focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                    />
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm 
                        text-sm font-medium text-white btn-gradient focus:outline-none focus:ring-2 
                        focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                    >
                        Hesap Oluştur
                    </button>
                </div>
            </form>
            
            <p class="mt-6 text-center text-sm text-gray-600">
                Zaten hesabınız var mı?
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-medium transition-colors">
                    Giriş Yapın
                </a>
            </p>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center">
                    Kayıt olarak, <a href="#" class="text-green-600">Hizmet Şartlarını</a> ve 
                    <a href="#" class="text-green-600">Gizlilik Politikasını</a> kabul etmiş olursunuz.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
