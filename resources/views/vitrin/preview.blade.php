<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $meta['title'] ?? 'Hekimport - Profil Önizleme' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? '' }}">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        .preview-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(0, 200, 179, 0.9);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            z-index: 50;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .edit-badge {
            position: fixed;
            top: 70px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 50;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Preview Badge -->
    <div class="preview-badge flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <span>Önizleme Modu</span>
    </div>
    
    <!-- Back to Editor Button -->
    <div class="fixed bottom-4 right-4 z-50">
        {{-- <a href="{{ route('filament.vitrinim.resources.profile.edit', ['record' => $vitrin->id]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2"> --}}
        {{-- TODO: Update this link to the new vitrin edit page route --}}
        <a href="{{ route('vitrinim.edit') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            <span>Düzenlemeye Dön</span>
        </a>
    </div>

    <!-- Main Content -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-12" src="{{ asset('img/hekimport-logo.svg') }}" alt="Hekimport">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Cover Photo -->
            <div class="h-48 bg-gradient-to-r from-primary-500 to-secondary-500 relative">
                @if($vitrin->getFirstMediaUrl('cover_photos'))
                    <img src="{{ $vitrin->getFirstMediaUrl('cover_photos') }}" alt="Cover Photo" class="w-full h-full object-cover">
                @endif
                
                <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                    Kapak Fotoğrafı
                </div>
            </div>
            
            <!-- Profile Header -->
            <div class="px-4 sm:px-6 lg:px-8 py-5 sm:flex sm:items-center sm:justify-between border-b border-gray-200">
                <div class="sm:flex sm:items-center">
                    <div class="relative group">
                        <div class="sm:flex-shrink-0">
                            @if($vitrin->getFirstMediaUrl('profile_photos'))
                                <img class="h-24 w-24 rounded-full ring-4 ring-white sm:mr-4" src="{{ $vitrin->getFirstMediaUrl('profile_photos') }}" alt="Profile Photo">
                            @else
                                <div class="h-24 w-24 rounded-full ring-4 ring-white bg-gray-200 flex items-center justify-center sm:mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Profil Fotoğrafı
                        </div>
                    </div>
                    
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 relative group">
                            {{ $vitrin->title ?? 'Doktor Adı - Uzmanlık Alanı' }}
                            
                            <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                                Başlık
                            </div>
                        </h1>
                        
                        <div class="mt-1 text-sm text-gray-500 flex items-center relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $vitrin->content['location']['city'] ?? 'Şehir' }}, {{ $vitrin->content['location']['address'] ?? 'Adres' }}
                            
                            <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                                Konum
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex justify-center sm:mt-0 relative group">
                    <a href="#contact" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Randevu Al
                    </a>
                    
                    <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                        Randevu Butonu
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-6 lg:px-8 py-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- About Section -->
                    <section class="relative group">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Hakkımda</h2>
                        
                        <div class="prose max-w-none">
                            <p>{{ $vitrin->content['bio'] ?? 'Hakkımda bilgisi henüz eklenmemiş.' }}</p>
                        </div>
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Hakkımda
                        </div>
                    </section>
                    
                    <!-- Services Section -->
                    <section class="relative group">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Hizmetler</h2>
                        
                        @if(!empty($vitrin->services) && count($vitrin->services) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($vitrin->services as $service)
                                    <div class="bg-gray-50 rounded-lg p-4 flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Hizmetler henüz eklenmemiş.</p>
                        @endif
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Hizmetler
                        </div>
                    </section>
                    
                    <!-- Gallery Section -->
                    <section class="relative group">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Galeri</h2>
                        
                        @if($vitrin->getMedia('gallery')->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($vitrin->getMedia('gallery') as $media)
                                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ $media->getUrl('thumb') }}" alt="Gallery Image {{ $loop->iteration }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Galeri fotoğrafları henüz eklenmemiş.</p>
                        @endif
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Galeri
                        </div>
                    </section>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Contact Information -->
                    <section id="contact" class="bg-gray-50 rounded-lg p-4 relative group">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">İletişim Bilgileri</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Telefon</p>
                                    <p class="text-sm text-gray-600">{{ $vitrin->contact_info['phone'] ?? 'Telefon numarası henüz eklenmemiş.' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">E-posta</p>
                                    <p class="text-sm text-gray-600">{{ $vitrin->contact_info['email'] ?? 'E-posta adresi henüz eklenmemiş.' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Adres</p>
                                    <p class="text-sm text-gray-600">{{ $vitrin->content['location']['address'] ?? 'Adres henüz eklenmemiş.' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            İletişim Bilgileri
                        </div>
                    </section>
                    
                    <!-- Working Hours -->
                    <section class="bg-gray-50 rounded-lg p-4 relative group">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Çalışma Saatleri</h3>
                        
                        @if(!empty($vitrin->working_hours) && count($vitrin->working_hours) > 0)
                            <div class="space-y-2">
                                @foreach($vitrin->working_hours as $workingHour)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium">{{ $workingHour['gun'] ?? '' }}</span>
                                        <span class="text-sm">{{ $workingHour['saat'] ?? '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Çalışma saatleri henüz eklenmemiş.</p>
                        @endif
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Çalışma Saatleri
                        </div>
                    </section>
                    
                    <!-- Social Media -->
                    <section class="bg-gray-50 rounded-lg p-4 relative group">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Sosyal Medya</h3>
                        
                        <div class="flex space-x-4">
                            @if(!empty($vitrin->social_media['instagram'] ?? ''))
                                <a href="https://{{ $vitrin->social_media['instagram'] }}" target="_blank" class="text-gray-400 hover:text-pink-600">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(!empty($vitrin->social_media['linkedin'] ?? ''))
                                <a href="https://{{ $vitrin->social_media['linkedin'] }}" target="_blank" class="text-gray-400 hover:text-blue-600">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                            @endif
                            
                            @if(!empty($vitrin->social_media['facebook'] ?? ''))
                                <a href="https://{{ $vitrin->social_media['facebook'] }}" target="_blank" class="text-gray-400 hover:text-blue-700">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(empty($vitrin->social_media['instagram'] ?? '') && empty($vitrin->social_media['linkedin'] ?? '') && empty($vitrin->social_media['facebook'] ?? ''))
                                <p class="text-gray-500">Sosyal medya hesapları henüz eklenmemiş.</p>
                            @endif
                        </div>
                        
                        <div class="edit-badge" x-data x-cloak x-show="$el.getBoundingClientRect().top > 0">
                            Sosyal Medya
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <p class="text-center text-base text-gray-400">
                        &copy; {{ date('Y') }} Hekimport. Tüm hakları saklıdır.
                    </p>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">
                        Bu sayfa önizleme modundadır.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Live Refresh Script -->
    <script>
        // In a real implementation, this would use WebSockets or Server-Sent Events to refresh the preview
        // when changes are made in the editor
        setTimeout(() => {
            const badges = document.querySelectorAll('.edit-badge');
            badges.forEach(badge => {
                badge.style.opacity = '1';
                setTimeout(() => {
                    badge.style.opacity = '0';
                }, 3000);
            });
        }, 1000);
    </script>
</body>
</html> 