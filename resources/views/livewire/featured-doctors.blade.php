<div>
    @if(!empty($doctors))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach($doctors as $doctor)
                <x-doctor-card :doctor="$doctor" />
            @endforeach
        </div>

        {{-- Optional: Link to see all doctors --}}
        <div class="text-center mt-12 md:mt-16">
            <a href="{{ route('doctor.search') }}" class="inline-flex items-center font-semibold group text-base md:text-lg text-primary-500 hover:text-primary-600">
                {{ __('welcome.view_all_doctors') }}
                <svg class="w-4 h-4 md:w-5 md:h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @else
        <p class="text-center text-gray-500">{{ __('welcome.no_featured_doctors') }}</p>
    @endif
</div>
