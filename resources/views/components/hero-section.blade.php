<section class="hero-section w-full bg-cover bg-no-repeat pb-24 min-h-[75vh] flex items-center relative overflow-hidden" 
         style="background-image: url('{{ asset('img/hero-image.png') }}'); background-position: 70% 20%;"> {{-- Clip-path kaldırıldı --}}
    
    {{-- Removed Dark Gradient Overlay --}}

    {{-- Decorative Emojis - Consider removing or handling with CSS ::before/::after for better semantics --}}
    {{-- Overlay / Shape (Optional - for design consistency) --}}
    {{-- 
    <div class="absolute top-0 right-0 w-7/12 h-full bg-white/5 clip-poly-custom z-10 hidden lg:block"></div> 
    <style>
        .clip-poly-custom { clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%); }
    </style>
    --}}

    <div class="hero-content relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-24"> {{-- Reduced top padding --}}
        <div class="flex flex-col md:flex-row items-start justify-between">
            <!-- Left Column: Heading, Tagline, Search Form -->
            <div class="w-full lg:w-8/12 mb-8 md:mb-0 text-center md:text-left relative">
                {{-- Glassmorphism effect with no sharp borders --}}
                <div class="relative md:ml-12 max-w-2xl mt-8">
                    {{-- Background blur circle effect --}}
                    <div class="absolute -top-12 -left-12 w-[130%] h-[130%] bg-gradient-to-br from-primary-500/40 via-teal-400/30 to-cyan-500/25 rounded-full blur-2xl -z-10"></div>
                    
                    {{-- Backlight glow effect --}}
                    <div class="absolute -top-4 -left-4 right-4 bottom-4 bg-gradient-to-br from-primary-500/30 to-cyan-500/20 rounded-3xl blur-xl -z-10"></div>
                    
                    <div class="p-8 md:p-10 rounded-3xl border" 
                         style="
                            background-color: rgba(255, 255, 255, 0.05) !important; /* Very subtle opacity */
                            backdrop-filter: blur(3px) !important;  /* Significantly reduced blur */
                            -webkit-backdrop-filter: blur(4px) !important; /* Safari compatibility */
                            box-shadow: 0 5px 20px -10px rgba(0, 0, 0, 0.3) !important; /* Much softer shadow */
                            border-color: rgba(0, 200, 179, 0.40) !important; /* Theme color (approx #00c8b3) with opacity */
                         ">
                        <h1 class="text-5xl sm:text-6xl md:text-7xl font-bold font-heading text-white leading-tight mb-6 relative" style="text-shadow: 0 4px 12px rgba(0,0,0,0.4);">
                            Diş Hekiminizi <br class="hidden sm:block">
                            <span class="relative">
                                Kolayca Bulun
                                {{-- Curved underline with glow --}}
                                <svg class="absolute h-3 w-full left-0 -bottom-2 drop-shadow-lg" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10C40 4 150 -2 298 7" stroke="url(#paint0_linear)" stroke-width="4" stroke-linecap="round"/>
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="0" y1="0" x2="300" y2="0" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#00c8b3"/>
                                            <stop offset="1" stop-color="#0099e5"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </h1>
                        <p class="text-xl sm:text-2xl text-white mb-10 opacity-100 max-w-3xl font-light" style="text-shadow: 0 2px 6px rgba(0,0,0,0.4);">
                             Türkiye'nin en geniş diş hekimi ağına göz atın.
                        </p>
                    
                        <!-- Search Form Component Placeholder -->
                        <x-search-form />
                        <!-- /Search Form Placeholder -->
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Optional decorative element (kept hidden for now) -->
            <div class="hidden lg:block absolute right-0 top-0 h-full w-1/3 z-0">
                {{-- 
                <div class="hero-decoration relative h-full">
                    <svg class="absolute right-0 h-full w-full text-white opacity-5" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0,300 C100,150 300,100 400,200 C500,300 600,350 800,250 L800,800 L0,800 Z" fill="currentColor"/>
                    </svg>
                </div>
                 --}}
            </div>
        </div>
    </div>
</section> 