@props(['doctor'])

<div class="doctor-card bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 border border-gray-100">
    <div class="p-5">
        <div class="flex items-center justify-center mb-5">
            @php
                // Get profile image from doctor data
                $profileImageUrl = isset($doctor['profile_image']) ? $doctor['profile_image'] : null;
                
                // Check if doctor is an array (from search page) or an object (from other contexts)
                $isArray = is_array($doctor);
                $name = $isArray ? $doctor['name'] : $doctor->name;
                $specialty = $isArray ? ($doctor['specialty'] ?? __('welcome.doctor_fallback_specialty')) : ($doctor->specialty ?? __('welcome.doctor_fallback_specialty'));
                
                // Remove prefixes from the doctor's name
                $nameParts = explode(' ', $name);
                // If we have multiple parts and the first part is a title, remove it
                if (count($nameParts) > 1 && in_array($nameParts[0], ['Dr.', 'Prof.', 'Doç.', 'Dr.', 'Dt.', 'Prof.', 'Dr.', 'Dt.'])) {
                    array_shift($nameParts);
                }
                // If we still have multiple parts and the first part is still a title, remove it
                if (count($nameParts) > 1 && in_array($nameParts[0], ['Dr.', 'Dt.'])) {
                    array_shift($nameParts);
                }
                $cleanName = implode(' ', $nameParts);
            @endphp
            
            @if($profileImageUrl)
                <img src="{{ $profileImageUrl }}" alt="{{ $cleanName }}" class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-primary-light">
            @else
                 {{-- Placeholder --}}
                <div class="w-28 h-28 md:w-32 md:h-32 rounded-full flex items-center justify-center border-4 bg-gray-100 border-primary-light">
                    <span class="text-2xl font-bold text-primary-500">DT</span>
                </div>
            @endif
        </div>
        <h3 class="text-lg md:text-xl font-semibold text-center mb-1 font-heading">{{ $cleanName }}</h3>
        <p class="text-gray-600 text-center text-sm mb-5">{{ $specialty }}</p>
        <div class="flex justify-center">
            @if($isArray && isset($doctor['vitrin_url']))
                <a href="{{ $doctor['vitrin_url'] }}" class="btn text-sm px-4 py-2 rounded bg-secondary-700 text-white hover:bg-secondary-800 transition duration-150 ease-in-out">
                    {{ __('welcome.view_profile') }}
                </a>
            @else
                <a href="{{ $doctor->vitrin ? url($doctor->vitrin->subdomain) : '#' }}" class="btn text-sm px-4 py-2 rounded bg-secondary-700 text-white hover:bg-secondary-800 transition duration-150 ease-in-out">
                    {{ __('welcome.view_profile') }}
                </a>
            @endif
        </div>
    </div>
</div> 