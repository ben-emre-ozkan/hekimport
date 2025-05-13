<x-app-layout>
    <div id="background" class="fixed top-0 left-0 w-full h-full -z-10 bg-gray-100"></div> {{-- Moved background div here, added basic Tailwind classes --}}

    {{-- Hero Section --}}
    <x-hero-section />

            <!-- Öne Çıkan Doktorlar -->
            <section class="py-16 md:py-24 bg-white">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 md:mb-16 font-heading">Öne Çıkan Diş Hekimlerimiz</h2>
                    
            <livewire:featured-doctors />
            
                </div>
            </section>
            
            <!-- Neden Biz Section -->
    <section class="py-16 md:py-24 features-section bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 md:mb-16 font-heading">Neden Hekimport?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                 <x-feature-card icon="✅" title="{{ __('welcome.feature1_title') }}">
                    {{ __('welcome.feature1_desc') }}
                 </x-feature-card>
                 
                 <x-feature-card icon="⏱️" title="{{ __('welcome.feature2_title') }}" colorClass="text-secondary-700">
                     {{ __('welcome.feature2_desc') }}
                 </x-feature-card>
                 
                 <x-feature-card icon="🔍" title="{{ __('welcome.feature3_title') }}">
                     {{ __('welcome.feature3_desc') }}
                 </x-feature-card>
                    </div>
                </div>
            </section>
</x-app-layout>
