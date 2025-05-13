<div class="flex flex-col h-full">
    <div class="flex items-center space-x-3 mb-4">
        <h3 class="text-lg font-medium text-gray-900">Klinik Özeti</h3>
    </div>
    
    @if($hasClinicInfo)
        <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="bg-blue-50 rounded-lg p-3 text-center">
                <div class="text-blue-600 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-xs font-medium text-gray-600">Çalışma Günleri</div>
                <div class="text-lg font-semibold text-gray-900">{{ count($workingHours) }}</div>
            </div>
            
            <div class="bg-indigo-50 rounded-lg p-3 text-center">
                <div class="text-indigo-600 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-xs font-medium text-gray-600">Personel</div>
                <div class="text-lg font-semibold text-gray-900">{{ $staffCount }}</div>
            </div>
            
            <div class="bg-purple-50 rounded-lg p-3 text-center">
                <div class="text-purple-600 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <div class="text-xs font-medium text-gray-600">Ekipman</div>
                <div class="text-lg font-semibold text-gray-900">{{ $equipmentCount }}</div>
            </div>
        </div>
        
        <div class="flex-grow">
            <div class="text-sm font-medium text-gray-700 mb-2">Çalışma Saatleri</div>
            <div class="bg-gray-50 rounded-lg p-2 text-sm">
                @if(count($workingHours) > 0)
                    <div class="space-y-1">
                        @foreach($workingHours as $day => $hours)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ $day }}:</span>
                                <span class="font-medium text-gray-800">{{ $hours }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-2">Çalışma saatleri belirtilmemiş</div>
                @endif
            </div>
        </div>
    @else
        <div class="flex items-center justify-center flex-grow">
            <div class="text-center">
                <div class="text-blue-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-gray-600 mb-3">Klinik bilgilerinizi ekleyin</p>
            </div>
        </div>
    @endif
    
    <div class="mt-4">
        <a href="{{ url('/masam/klinik') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
            <span>Kliniğimi Yönet</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div> 