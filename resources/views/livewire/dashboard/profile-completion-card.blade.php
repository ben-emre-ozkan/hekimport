<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Vitrin Tamamlanma Oranı</h3>
        <div class="text-sm font-medium text-gray-900">{{ $completionPercentage }}%</div>
    </div>
    
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
        <div class="bg-gradient-to-r from-teal-500 to-blue-500 h-2.5 rounded-full transition-all duration-700" style="width: {{ $completionPercentage }}%"></div>
    </div>
    
    <div class="flex-grow">
        @if(count($missingFields) > 0)
            <div class="text-sm text-gray-600 mb-2">Tamamlanması gereken alanlar:</div>
            <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                @foreach($missingFields as $field)
                    <li>{{ $field }}</li>
                @endforeach
            </ul>
        @else
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <div class="mb-2 text-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-700">Tebrikler! Vitrin profiliniz tamamlandı.</p>
                </div>
            </div>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('vitrinim') }}" class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-700">
            <span>Vitrinimi Düzenle</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div> 