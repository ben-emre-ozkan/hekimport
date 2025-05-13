<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Diş Hekimi Profili - Hekimport' }}</title>
    <meta name="description" content="{{ $description ?? 'Diş hekimi profili' }}">
    <meta name="keywords" content="{{ $keywords ?? 'diş hekimi, dişçi' }}">

    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalOrganization",
        "name": "{{ $vitrin->subdomain ?? 'Diş Hekimi' }}",
        "description": "{{ $description }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "{{ $vitrin->content['location']['city'] ?? '' }}",
            "addressRegion": "{{ $vitrin->content['location']['state'] ?? '' }}",
            "addressCountry": "{{ $vitrin->content['location']['country'] ?? 'TR' }}"
        },
        "medicalSpecialty": [
            @if(isset($vitrin->content['specialties']) && is_array($vitrin->content['specialties']))
                @foreach($vitrin->content['specialties'] as $specialty)
                    "{{ $specialty }}"{{ !$loop->last ? ',' : '' }}
                @endforeach
            @endif
        ],
        "openingHours": [
            @if(isset($vitrin->working_hours) && is_array($vitrin->working_hours))
                @foreach($vitrin->working_hours as $day => $hours)
                    "{{ $day }} {{ is_array($hours) ? implode(', ', $hours) : $hours }}"{{ !$loop->last ? ',' : '' }}
                @endforeach
            @endif
        ]
    }
    </script>

    <!-- OpenGraph Tags -->
    <meta property="og:title" content="{{ $title ?? 'Diş Hekimi Profili - Hekimport' }}">
    <meta property="og:description" content="{{ $description ?? 'Diş hekimi profili' }}">
    <meta property="og:image" content="{{ $profileImage ?? asset('images/default-profile.jpg') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="profile">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title ?? 'Diş Hekimi Profili - Hekimport' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Diş hekimi profili' }}">
    <meta name="twitter:image" content="{{ $profileImage ?? asset('images/default-profile.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @livewireStyles
</head>
<body>
    <!-- Site Header -->
    <x-header />

    <div class="min-h-screen bg-gray-50">
        <!-- Dentist Profile Header -->
        <x-profile.header :vitrin="$vitrin" />

        <!-- Edit Button for Dentist viewing their own profile -->
        @auth
            @php
                $isOwnProfile = false;
                try {
                    $user = Auth::user();
                    $isOwnProfile = $user->hasRole('dentist') && $user->vitrin && $user->vitrin->id == $vitrin->id;
                } catch (\Exception $e) {
                    $isOwnProfile = false;
                }
            @endphp

            @if($isOwnProfile)
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-8 flex justify-end z-50 relative">
                    <a href="{{ route('vitrinim') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg text-white font-medium shadow-md hover:from-cyan-600 hover:to-blue-600 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Profilimi Düzenle
                    </a>
                </div>
            @endif
        @endauth

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6 md:space-y-8">
                    <!-- Hakkımda Section -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Hakkımda</h2>
                        <div class="prose max-w-none">
                            @php
                                try {
                                    $aboutContent = $vitrin->content['about'] ?? $vitrin->content['bio'] ?? 'Henüz bilgi girilmemiş.';
                                } catch (\Exception $e) {
                                    $aboutContent = 'Henüz bilgi girilmemiş.';
                                }
                            @endphp
                            {!! $aboutContent !!}
                        </div>
                    </section>

                    <!-- Services Component -->
                    @if(isset($vitrin->content['services']) && is_array($vitrin->content['services']))
                        <livewire:services :services="$vitrin->content['services']" />
                    @else
                        <section class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Hizmetler</h2>
                            <p class="text-gray-500">Henüz hizmet bilgisi eklenmemiş.</p>
                        </section>
                    @endif

                    <!-- Education & Certifications -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Eğitim ve Sertifikalar</h2>
                        <div class="space-y-4">
                            @if(isset($vitrin->content['education']) && is_array($vitrin->content['education']))
                                @foreach($vitrin->content['education'] as $edu)
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $edu['institution'] ?? $edu['university'] ?? '' }}</h3>
                                        <p class="text-gray-600">{{ $edu['degree'] ?? '' }} - {{ $edu['year'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Henüz eğitim bilgisi eklenmemiş.</p>
                            @endif
                        </div>
                    </section>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Contact Information -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">İletişim</h2>
                        <div class="space-y-4">
                            @php
                                try {
                                    $locationAddress = $vitrin->content['location']['address'] ?? null;
                                    $contactPhone = $vitrin->content['contact']['phone'] ?? null;
                                    if (!$contactPhone && is_array($vitrin->contact_info)) {
                                        $contactPhone = $vitrin->contact_info['phone'] ?? null;
                                    }
                                    
                                    $contactEmail = $vitrin->content['contact']['email'] ?? null;
                                    if (!$contactEmail && is_array($vitrin->contact_info)) {
                                        $contactEmail = $vitrin->contact_info['email'] ?? null;
                                    }
                                } catch (\Exception $e) {
                                    $locationAddress = null;
                                    $contactPhone = null;
                                    $contactEmail = null;
                                }
                            @endphp

                            @if($locationAddress)
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="ml-3 text-gray-600">{{ $locationAddress }}</span>
                            </div>
                            @endif
                            
                            @if($contactPhone)
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="ml-3 text-gray-600">{{ $contactPhone }}</span>
                            </div>
                            @endif
                            
                            @if($contactEmail)
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="ml-3 text-gray-600">{{ $contactEmail }}</span>
                            </div>
                            @endif

                            @if(!$locationAddress && !$contactPhone && !$contactEmail)
                            <p class="text-gray-500">İletişim bilgileri henüz eklenmemiş.</p>
                            @endif
                        </div>
                    </section>

                    <!-- Working Hours -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Çalışma Saatleri</h2>
                        <div class="space-y-2">
                            @php
                                try {
                                    $workingHours = $vitrin->working_hours;
                                    $hasWorkingHours = is_array($workingHours) && !empty($workingHours);
                                } catch (\Exception $e) {
                                    $hasWorkingHours = false;
                                }
                            @endphp

                            @if($hasWorkingHours)
                                @foreach($workingHours as $day => $hours)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ $day }}</span>
                                        <span class="font-medium">{{ is_array($hours) ? implode(', ', $hours) : $hours }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Çalışma saatleri belirtilmemiş.</p>
                            @endif
                        </div>
                    </section>

                    <!-- Randevu Al Button -->
                    @if($hasWorkingHours)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Randevu Al</h2>
                        <p class="text-gray-600 mb-4">{{ $vitrin->content['name'] ?? $vitrin->subdomain }} ile hızlı bir şekilde randevu alabilirsiniz.</p>
                        <button 
                            type="button"
                            @click="$dispatch('open-appointment-modal')"
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-blue-500 hover:from-teal-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                        >
                            Randevu Talebi Oluştur
                        </button>
                    </div>
                    @else
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Randevu Al</h2>
                        <p class="text-gray-500">Randevu sistemi henüz aktif değil.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Request Modal -->
    @if($hasWorkingHours)
        <div 
            x-data="{
                openModal: false
            }"
            @open-appointment-modal.window="openModal = true"
        >
            <template x-teleport="body">
                <div x-show="openModal">
                    <x-profile.appointment-request-modal :vitrin="$vitrin" />
                </div>
            </template>
        </div>
    @endif

    @livewireScripts
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentRequestModal', () => ({
                open: false,
                init() {
                    this.$watch('openModal', (value) => {
                        this.open = value;
                    });
                }
            }));
        });
    </script>
</body>
</html> 