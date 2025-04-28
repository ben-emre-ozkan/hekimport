<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Dashboard</title>
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Brand Colors */
        :root {
            --primary: 175, 200, 179;
            --primary-50: 240, 253, 250;
            --primary-100: 204, 251, 241;
            --primary-500: 0, 200, 179;
            --primary-600: 0, 159, 142;
            --primary-700: 0, 127, 113;
            
            --secondary: 0, 153, 229;
            --secondary-500: 0, 153, 229;
            --secondary-600: 2, 132, 199;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <!-- Logo -->
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-[#00c8b3]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.75 4A2.75 2.75 0 002 6.75v1.5a2.75 2.75 0 002.75 2.75h10.5A2.75 2.75 0 0018 8.25v-1.5A2.75 2.75 0 0015.25 4h-10.5zm9.5 3.25a.75.75 0 000 1.5h1a.75.75 0 000-1.5h-1zm-2 0a.75.75 0 000 1.5h1a.75.75 0 000-1.5h-1zm-8 8A2.75 2.75 0 002 18.25v1.5A2.75 2.75 0 004.75 22h10.5A2.75 2.75 0 0018 19.75v-1.5A2.75 2.75 0 0015.25 15h-10.5zm9.5 3.25a.75.75 0 000 1.5h1a.75.75 0 000-1.5h-1zm-2 0a.75.75 0 000 1.5h1a.75.75 0 000-1.5h-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-2 text-xl font-bold text-gray-900">🦷 HEKİMPORT</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <div class="relative">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="flex-1">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Masam</h1>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Welcome Panel -->
                    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-[#00c8b3] to-[#0099e5] text-white">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <div>
                                    <h2 class="text-xl font-bold">Merhaba, {{ auth()->user()->name }}!</h2>
                                    <p class="mt-1">Hekimport platformuna hoş geldiniz. Buradan profilinizi ve klinik bilgilerinizi yönetebilirsiniz.</p>
                                </div>
                                <div class="mt-4 md:mt-0">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-teal-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10c0-5.523-4.477-10-10-10zm0 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
                                            </svg>
                                            Profilim
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Overview -->
                    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Vitrin Stats Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-[#00c8b3]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8zm-.5-13c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5S13 9.328 13 8.5 12.328 7 11.5 7zm-3 6.5c.415 0 .75.335.75.75s-.335.75-.75.75-.75-.335-.75-.75.335-.75.75-.75-.75zm5.75.75c0-.415.335-.75.75-.75s.75.335.75.75-.335.75-.75.75-.75-.335-.75-.75zM12 14c-1.237 0-2.371.687-2.934 1.783-.102.2-.051.442.115.589.139.124.34.148.51.068.842-.395 1.777-.396 2.619 0 .17.08.37.057.51-.068.166-.147.217-.389.115-.589-.564-1.096-1.698-1.783-2.935-1.783z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Vitrin Görüntülenme</dt>
                                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ rand(20, 150) }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="{{ route('vitrinim') }}" class="font-medium text-[#00c8b3] hover:text-[#009185]">Vitrin detaylarına git</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Appointment Stats Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-[#0099e5]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Bugünkü Randevular</dt>
                                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ rand(1, 8) }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="{{ route('klinik') }}" class="font-medium text-[#0099e5] hover:text-[#007bb8]">Randevu detaylarına git</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Patient Stats Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-[#00c8b3]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Toplam Hasta</dt>
                                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ rand(50, 250) }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="{{ route('klinik') }}" class="font-medium text-[#00c8b3] hover:text-[#009185]">Hasta listesine git</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Access -->
                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Vitrinim Card -->
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-[#ebfaf8] p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#00c8b3]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-lg font-semibold text-gray-900">Vitrinim</h3>
                                        <p class="mt-1 text-sm text-gray-600">Çevrimiçi görünürlüğünüzü yönetin ve profilinizi güncelleyin</p>
                                        <div class="mt-4">
                                            <span class="inline-flex rounded-md shadow-sm">
                                                <a href="{{ route('vitrinim') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#00c8b3] hover:bg-[#009e8d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00c8b3] transition-colors duration-150">
                                                    Vitrini Yönet
                                                    <svg class="ml-2 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Klinik Card -->
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-[#e6f4fd] p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0099e5]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2h1v1H4v-1h1v-2H4v-1h16v1h-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-lg font-semibold text-gray-900">Kliniğim</h3>
                                        <p class="mt-1 text-sm text-gray-600">Klinik işlemlerini ve randevularınızı yönetin</p>
                                        <div class="mt-4">
                                            <span class="inline-flex rounded-md shadow-sm">
                                                <a href="{{ route('klinik') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#0099e5] hover:bg-[#007bb8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0099e5] transition-colors duration-150">
                                                    Kliniğe Git
                                                    <svg class="ml-2 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
                <p class="text-center text-base text-gray-500">&copy; {{ date('Y') }} Hekimport. Tüm hakları saklıdır.</p>
            </div>
        </footer>
    </div>
</body>
</html> 