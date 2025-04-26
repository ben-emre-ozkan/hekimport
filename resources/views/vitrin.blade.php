<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $vitrin->subdomain }}</h1>
                        <p class="mt-2 text-lg text-gray-600">{{ $vitrin->content['bio'] }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Uzmanlıklar</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vitrin->content['specialties'] as $specialty)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $specialty }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold mb-4">İletişim</h2>
                            <p class="text-gray-600">
                                <span class="font-medium">Şehir:</span> {{ $vitrin->content['location']['city'] }}
                            </p>
                        </div>
                    </div>

                    @if($vitrin->content['hours'])
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold mb-4">Çalışma Saatleri</h2>
                            <div class="prose max-w-none">
                                {!! $vitrin->content['hours'] !!}
                            </div>
                        </div>
                    @endif

                    @if($vitrin->content['booking_form'])
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold mb-4">Randevu Formu</h2>
                            <div class="prose max-w-none">
                                {!! $vitrin->content['booking_form'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 