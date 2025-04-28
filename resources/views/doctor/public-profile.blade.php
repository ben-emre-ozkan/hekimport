<x-app-layout>
    @section('meta')
        <meta name="title" content="{{ $meta['title'] }}">
        <meta name="description" content="{{ $meta['description'] }}">
        <meta name="keywords" content="{{ $meta['keywords'] }}">
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-start gap-8">
                        <!-- Doctor Image -->
                        <div class="w-full md:w-1/3">
                            @if($doctor->profile_image)
                                <img src="{{ asset('storage/' . $doctor->profile_image) }}" 
                                     alt="Dr. {{ $doctor->name }}" 
                                     class="w-full h-64 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-64 bg-teal-100 rounded-lg shadow-md flex items-center justify-center">
                                    <span class="text-6xl">👨‍⚕️</span>
                                </div>
                            @endif
                        </div>

                        <!-- Doctor Info -->
                        <div class="w-full md:w-2/3">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dr. {{ $doctor->name }}</h1>
                            <p class="text-xl text-teal-600 mb-4">{{ $doctor->specialty }}</p>
                            
                            @if($doctor->profile)
                                <div class="prose max-w-none">
                                    <h2 class="text-xl font-semibold mb-2">Hakkında</h2>
                                    <p class="text-gray-600 mb-6">{{ $doctor->profile->bio }}</p>

                                    @if($doctor->profile->education)
                                        <h2 class="text-xl font-semibold mb-2">Eğitim</h2>
                                        <ul class="list-disc list-inside text-gray-600 mb-6">
                                            @foreach($doctor->profile->education as $edu)
                                                <li>{{ $edu }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($doctor->profile->experience)
                                        <h2 class="text-xl font-semibold mb-2">Deneyim</h2>
                                        <ul class="list-disc list-inside text-gray-600 mb-6">
                                            @foreach($doctor->profile->experience as $exp)
                                                <li>{{ $exp }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($doctor->profile->certifications)
                                        <h2 class="text-xl font-semibold mb-2">Sertifikalar</h2>
                                        <ul class="list-disc list-inside text-gray-600 mb-6">
                                            @foreach($doctor->profile->certifications as $cert)
                                                <li>{{ $cert }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif

                            <!-- Contact Information -->
                            <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                                <h2 class="text-xl font-semibold mb-4">İletişim Bilgileri</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($doctor->profile?->phone)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $doctor->profile->phone }}</span>
                                        </div>
                                    @endif

                                    @if($doctor->profile?->address)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $doctor->profile->address }}</span>
                                        </div>
                                    @endif

                                    @if($doctor->profile?->website)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                            <a href="{{ $doctor->profile->website }}" target="_blank" class="text-teal-600 hover:text-teal-800">{{ $doctor->profile->website }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 