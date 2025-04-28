<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="Hekimport - MASAM">
    <meta name="description" content="Hekimport MASAM'a giriş yapın ve diş hekimi vitrininizi yönetin.">
    <meta name="keywords" content="hekimport, diş hekimi giriş, dişçi platformu, diş hekimi">

    <title>MASAM | Hekimport</title>

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
        </div>
    </header>

    <div class="min-h-screen gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 pt-32">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full card-hover">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/favicon.png') }}" alt="Hekimport Logo" class="h-16 w-auto">
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">MASAM</h2>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 text-sm rounded-lg bg-green-50 text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-posta Adresi</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
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
                        autocomplete="current-password" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm transition-all duration-200
                        focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50
                        @error('password') border-red-500 bg-red-50 @enderror"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" 
                            name="remember"
                        >
                        <span class="ml-2 text-sm text-gray-600">Beni Hatırla</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-800 transition-colors">
                            Şifremi Unuttum?
                        </a>
                    @endif
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm 
                        text-sm font-medium text-white btn-gradient focus:outline-none focus:ring-2 
                        focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                    >
                        Giriş Yap
                    </button>
                </div>
            </form>
            
            <p class="mt-6 text-center text-sm text-gray-600">
                Henüz hesabınız yok mu?
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 font-medium transition-colors">
                    Hemen Kaydolun
                </a>
            </p>
        </div>
    </div>
</body>
</html>
