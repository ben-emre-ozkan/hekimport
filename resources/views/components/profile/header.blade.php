@props(['vitrin'])

<div class="bg-gradient-to-r from-cyan-500 to-blue-500 shadow-lg text-white mt-16 pt-8">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
        <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
            <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                <img src="{{ $vitrin->content['profile_image'] ?? asset('images/default-profile.jpg') }}" 
                     alt="{{ $vitrin->subdomain }} Profile" 
                     class="rounded-full w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-36 lg:h-36 object-cover mx-auto md:mx-0 ring-4 ring-white shadow-xl"
                     loading="lazy">
            </div>
            <div class="w-full md:w-2/3 text-center md:text-left">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white">{{ $vitrin->subdomain }}</h1>
                <p class="mt-2 md:mt-3 text-sm sm:text-base md:text-lg text-white/90 line-clamp-2 md:line-clamp-3">{{ $vitrin->content['bio'] ?? 'Diş hekimi profili' }}</p>
                <div class="mt-3 md:mt-5 flex flex-wrap gap-1 md:gap-2 justify-center md:justify-start">
                    @if(isset($vitrin->content['specialties']) && is_array($vitrin->content['specialties']))
                        @foreach($vitrin->content['specialties'] as $specialty)
                            <span class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 lg:px-4 lg:py-2 rounded-full text-xs md:text-sm font-medium bg-white/20 backdrop-blur-sm text-white">
                                {{ $specialty }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spacing for content below -->
<div class="h-6 md:h-8 lg:h-10"></div> 