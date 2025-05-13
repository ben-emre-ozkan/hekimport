<header class="py-5 w-full z-50 absolute top-0 left-0 bg-black/30 backdrop-blur-sm" style="background-color: rgba(0,0,0,0.20) !important;" x-data="mobileMenu" @click.away="closeOnClickAway($event)">
    <div class="w-full px-6 flex items-center justify-between">
        <a href="/" class="flex items-center space-x-3">
            <img src="{{ asset('img/favicon.png') }}" alt="Hekimport Favicon" class="block h-12 md:h-14 w-auto">
            <span class="font-orbitron text-2xl md:text-3xl font-bold text-white">HEKİMPORT</span>
        </a>
        
        <!-- Mobile Menu Toggle -->
        <div class="md:hidden">
            <button @click="toggle()" x-ref="toggleButton" id="mobileMenuToggle" class="mobile-menu-toggle text-white" aria-label="Toggle mobile menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6">
            <!-- Ana Navigasyon -->
            <nav class="flex items-center space-x-8 mr-6">
                <a href="/market" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">Market</a>
                <a href="/forum" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">Forum</a>
                <a href="/akademi" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">Akademi</a>
                <a href="/gizlilik" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">Veri Gizliliği</a>
                <a href="/yardim" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">Yardım Merkezi</a>
            </nav>
            
            @if (Route::has('login'))
                <nav class="flex items-center space-x-6">
                    @auth
                        {{-- Logged-in user links --}}
                        @php
                            try {
                                $isUserDentist = Auth::user()->hasRole('dentist');
                            } catch (\Exception $e) {
                                $isUserDentist = false;
                            }
                        @endphp

                        @if($isUserDentist)
                            <a href="{{ route('masam') }}" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">{{ __('welcome.dentist_panel') }}</a>
                        @else
                            <a href="{{ url('/') }}" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">{{ __('welcome.my_account') }}</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link text-sm font-medium text-white hover:text-gray-200 tracking-wide">{{ __('welcome.logout') }}</button>
                        </form>
                    @else
                        {{-- Guest user links --}}
                        <div class="flex items-center space-x-4">
                             <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium bg-primary-500 text-white shadow-md hover:bg-primary-600 transition-all duration-200">
                                {{ __('welcome.my_desk') }}
                            </a>
                            <a href="{{ route('register') }}?type=doctor" class="text-sm font-medium text-white hover:text-primary-200 transition-all duration-200 tracking-wide">
                                {{ __('welcome.are_you_dentist') }}
                            </a>
                        </div>
                    @endif
                </nav>
            @endif
            
            {{-- Gereksiz form öğelerini kaldırdım --}}
        </div>
    </div>
    
    <!-- Mobile Menu Container -->
    <div x-show="open" x-ref="menuContainer" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         id="mobileMenu" 
         class="mobile-menu-container absolute top-full left-0 w-full bg-primary-600 p-4 shadow-lg md:hidden" 
         style="display: none;" 
         @click.stop > 
        @if (Route::has('login'))
            @auth
                 @php
                    try {
                        $isUserDentist = Auth::user()->hasRole('dentist');
                    } catch (\Exception $e) {
                        $isUserDentist = false;
                    }
                @endphp

                @if($isUserDentist)
                    <a href="{{ route('masam') }}" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">{{ __('welcome.dentist_panel') }}</a>
                @else
                    <a href="{{ url('/') }}" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">{{ __('welcome.my_account') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">{{ __('welcome.logout') }}</button>
                </form>
            @else
                 <div class="mobile-menu-title text-white font-bold text-center mb-3">{{ __('welcome.dentist_question') }}</div>
                <a href="{{ route('login') }}" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white text-primary-500 font-bold shadow-md hover:bg-gray-100">
                    {{ __('welcome.my_desk') }}
                </a>
                <a href="{{ route('register') }}?type=doctor" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                    {{ __('welcome.register') }}
                </a>
            @endif
        @endif
        
        <!-- Mobil Menu Links -->
        <div class="pt-3 pb-2 border-t border-white/10">
            <a href="/market" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                <i class="fas fa-shopping-cart mr-2"></i>Market
            </a>
            <a href="/forum" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                <i class="fas fa-comments mr-2"></i>Forum
            </a>
            <a href="/akademi" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                <i class="fas fa-graduation-cap mr-2"></i>Akademi
            </a>
            <a href="/gizlilik" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                <i class="fas fa-shield-alt mr-2"></i>Veri Gizliliği
            </a>
            <a href="/yardim" class="mobile-menu-btn block w-full text-center p-3 mb-2 rounded bg-white/10 text-white font-semibold hover:bg-white/20">
                <i class="fas fa-question-circle mr-2"></i>Yardım Merkezi
            </a>
        </div>
    </div>
</header>