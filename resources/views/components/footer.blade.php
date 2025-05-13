<footer class="text-gray-300 py-12 bg-secondary-700"> {{-- Use Tailwind color --}}
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Column 1: Logo and Tagline --}}
            <div>
                <a href="/" class="flex items-center mb-4">
                     {{-- Use text-white or adjust as needed --}}
                    <h2 class="font-orbitron text-2xl font-bold text-white">HEKİMPORT</h2> 
                </a>
                <p class="text-sm text-white opacity-90 mb-4">{{ __('welcome.footer_tagline') }}</p>
            </div>
            
            {{-- Column 2: Quick Links --}}
            <div>
                <h3 class="text-lg font-semibold text-white mb-4 font-heading">{{ __('welcome.quick_links') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">{{ __('welcome.about_us') }}</a></li>
                    <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">{{ __('welcome.privacy_policy') }}</a></li>
                    <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">{{ __('welcome.terms_of_use') }}</a></li>
                    <li><a href="#" class="text-white opacity-90 hover:opacity-100 transition">{{ __('welcome.contact') }}</a></li>
                </ul>
            </div>
            
            {{-- Column 3: Contact Info --}}
            <div>
                <h3 class="text-lg font-semibold text-white mb-4 font-heading">{{ __('welcome.contact_info') }}</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@hekimport.com
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +90 (212) 123 45 67
                    </li>
                </ul>
            </div>
        </div>
        
        {{-- Bottom Copyright Text --}}
        <div class="border-t border-white border-opacity-20 mt-10 pt-8 text-center text-sm text-white opacity-90">
            <p>{{ __('welcome.copyright', ['year' => date('Y')]) }}</p>
        </div>
    </div>
</footer> 