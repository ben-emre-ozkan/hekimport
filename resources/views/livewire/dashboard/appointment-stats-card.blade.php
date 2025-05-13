<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Randevu İstatistikleri</h3>
        <span class="text-sm text-gray-500">{{ $todayDate }}</span>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="bg-green-50 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $todayAppointments }}</div>
            <div class="text-sm font-medium text-gray-600">Bugünkü Randevular</div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $weeklyAppointments }}</div>
            <div class="text-sm font-medium text-gray-600">Haftalık Randevular</div>
        </div>
    </div>
    
    <div class="flex-grow">
        <div class="text-sm font-medium text-gray-700 mb-2">Bugünkü Randevular</div>
        
        @if(count($upcomingAppointments) > 0)
            <div class="space-y-2">
                @foreach($upcomingAppointments as $appointment)
                    <div class="bg-white rounded-md border border-gray-200 p-3">
                        <div class="flex items-center justify-between">
                            <div class="font-medium text-gray-900">{{ $appointment['time'] }}</div>
                            <div class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">{{ $appointment['treatment'] }}</div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">{{ $appointment['patient'] }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                Bugün için randevunuz bulunmamaktadır.
            </div>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('vitrinim') }}?tab=appointments" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-700">
            <span>Tüm Randevuları Görüntüle</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div> 