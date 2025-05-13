<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- SEO Meta Tags --}}
        <title>@yield('title', config('app.name', 'Hekimport'))</title>
        <meta name="description" content="@yield('description', 'Hekimport ile Türkiye\'deki en iyi diş hekimlerini bulun, randevu alın ve diş sağlığınızı yönetin.')">
        <meta name="keywords" content="@yield('keywords', 'diş hekimi, hekimport, dişçi ara, diş hekimi bul, randevu al')">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', config('app.name', 'Hekimport'))">
        <meta property="og:description" content="@yield('description', 'Hekimport ile Türkiye\'deki en iyi diş hekimlerini bulun, randevu alın ve diş sağlığınızı yönetin.')">
        <meta property="og:image" content="@yield('og:image', asset('img/hekimport-og-image.png'))"> {{-- Default OG image --}}

        {{-- Twitter --}}
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', config('app.name', 'Hekimport'))">
        <meta property="twitter:description" content="@yield('description', 'Hekimport ile Türkiye\'deki en iyi diş hekimlerini bulun, randevu alın ve diş sağlığınızı yönetin.')">
        <meta property="twitter:image" content="@yield('og:image', asset('img/hekimport-og-image.png'))"> {{-- Use same image as OG --}}

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles {{-- Add Livewire styles --}}

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <x-header />

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <x-footer />
        </div>
         @livewireScripts {{-- Add Livewire scripts --}}
    </body>
</html>
