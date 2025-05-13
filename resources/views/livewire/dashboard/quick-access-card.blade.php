<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Hızlı Erişim</h3>
    </div>
    
    <div class="grid grid-cols-2 gap-2 mb-4">
        @foreach($quickLinks as $link)
            <a href="{{ $link['url'] }}" class="flex flex-col items-center p-3 rounded-lg {{ $link['color'] }} hover:opacity-80 transition-opacity duration-200">
                <div class="mb-1">
                    @if($link['icon'] == 'plus-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif($link['icon'] == 'clock')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif($link['icon'] == 'pencil-alt')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    @elseif($link['icon'] == 'location-marker')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    @elseif($link['icon'] == 'user-add')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    @elseif($link['icon'] == 'calendar')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
                <span class="text-xs font-medium">{{ $link['name'] }}</span>
            </a>
        @endforeach
    </div>
    
    <div class="flex-grow">
        <div class="text-sm font-medium text-gray-700 mb-2">Son Etkinlikler</div>
        <div class="space-y-2 overflow-y-auto max-h-32">
            @foreach($recentItems as $item)
                <div class="bg-gray-50 rounded-lg p-2 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-800">{{ $item['type'] }}: {{ $item['name'] }}</span>
                        <span class="text-xs text-gray-500">{{ $item['time'] }}</span>
                    </div>
                    <div class="text-xs text-gray-600 mt-1">{{ ucfirst($item['action']) }}</div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
            <span>Hesap Ayarları</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div> 