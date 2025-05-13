<div>
    <h2 class="text-xl font-medium text-gray-900 mb-6">Çalışma Saatleri</h2>
    
    <p class="text-gray-600 mb-6">Hastaların randevu alabilmesi için müsait olduğunuz saatleri belirleyin.</p>
    
    <div class="mb-8">
        <!-- Tabs for different appointment management sections -->
        <div class="border-b border-gray-200 mb-6" x-data="{ activeTab: 'single' }">
            <nav class="flex -mb-px space-x-6">
                <button 
                    @click="activeTab = 'single'" 
                    :class="activeTab === 'single' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-3 px-1 border-b-2 font-medium text-sm">
                    Tek Seferlik Saatler
                </button>
                <button 
                    @click="activeTab = 'recurring'" 
                    :class="activeTab === 'recurring' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-3 px-1 border-b-2 font-medium text-sm">
                    Tekrarlayan Saatler
                </button>
                <button 
                    @click="activeTab = 'vacation'" 
                    :class="activeTab === 'vacation' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-3 px-1 border-b-2 font-medium text-sm">
                    İzin Dönemleri
                </button>
            </nav>
        </div>
        
        <!-- Single time slots section -->
        <div x-data="{ activeTab: 'single' }" x-show="activeTab === 'single'">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Yeni Saat Dilimi Ekle</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="selectedDay" class="block text-sm font-medium text-gray-700 mb-1">Gün</label>
                        <select id="selectedDay" wire:model="selectedDay" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="Monday">Pazartesi</option>
                            <option value="Tuesday">Salı</option>
                            <option value="Wednesday">Çarşamba</option>
                            <option value="Thursday">Perşembe</option>
                            <option value="Friday">Cuma</option>
                            <option value="Saturday">Cumartesi</option>
                            <option value="Sunday">Pazar</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Saati</label>
                        <select id="startTime" wire:model="startTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @for($hour = 8; $hour <= 20; $hour++)
                                @for($min = 0; $min < 60; $min += 30)
                                    @php 
                                        $time = sprintf('%02d:%02d', $hour, $min);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 mb-1">Bitiş Saati</label>
                        <select id="endTime" wire:model="endTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @for($hour = 8; $hour <= 21; $hour++)
                                @for($min = 0; $min < 60; $min += 30)
                                    @php 
                                        $time = sprintf('%02d:%02d', $hour, $min);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button 
                        type="button" 
                        wire:click="addSlot"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Saat Dilimi Ekle
                    </button>
                </div>
            </div>
            
            <div x-data="{ openDay: null }">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Mevcut Çalışma Saatleri</h3>
                
                @php
                    $dayNames = [
                        'Monday' => 'Pazartesi',
                        'Tuesday' => 'Salı',
                        'Wednesday' => 'Çarşamba',
                        'Thursday' => 'Perşembe',
                        'Friday' => 'Cuma',
                        'Saturday' => 'Cumartesi',
                        'Sunday' => 'Pazar',
                    ];
                @endphp
                
                <div class="space-y-4">
                    @foreach($dayNames as $dayKey => $dayName)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div
                                @click="openDay = openDay === '{{ $dayKey }}' ? null : '{{ $dayKey }}'"
                                class="flex items-center justify-between bg-gray-50 px-4 py-3 cursor-pointer"
                            >
                                <h4 class="font-medium text-gray-900">{{ $dayName }}</h4>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 mr-2">
                                        {{ count($working_hours[$dayKey] ?? []) }} saat dilimi
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform" :class="{'rotate-180': openDay === '{{ $dayKey }}'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div x-show="openDay === '{{ $dayKey }}'" x-collapse x-cloak>
                                <div class="px-4 py-3">
                                    @if(count($working_hours[$dayKey] ?? []) > 0)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                            @foreach($working_hours[$dayKey] as $slot)
                                                <div class="flex items-center justify-between bg-blue-50 px-3 py-2 rounded">
                                                    <span class="text-blue-800">{{ $slot }}</span>
                                                    <button
                                                        type="button"
                                                        wire:click="removeSlot('{{ $dayKey }}', '{{ $slot }}')"
                                                        class="text-red-500 hover:text-red-700"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-2 text-gray-500">
                                            Bu gün için tanımlanmış saat dilimi yok.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Recurring appointments section -->
        <div x-data="{ activeTab: 'recurring' }" x-show="activeTab === 'recurring'">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tekrarlayan Randevu Şablonu Oluştur</h3>
                
                <p class="text-sm text-gray-600 mb-4">Tekrarlayan randevular için bir şablon oluşturun. Bu şablonu kullanarak her hafta aynı zaman dilimlerini otomatik olarak açabilirsiniz.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="recurringPattern" class="block text-sm font-medium text-gray-700 mb-1">Tekrarlama Aralığı</label>
                        <select id="recurringPattern" wire:model="recurringPattern" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="weekly">Haftalık</option>
                            <option value="biweekly">İki Haftada Bir</option>
                            <option value="monthly">Aylık</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="recurringDay" class="block text-sm font-medium text-gray-700 mb-1">Gün Seçimi</label>
                        <div class="mt-1 grid grid-cols-7 gap-1">
                            @foreach(['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'] as $index => $dayShort)
                                <div class="flex items-center justify-center">
                                    <button 
                                        type="button"
                                        wire:click="toggleRecurringDay({{ $index }})"
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium focus:outline-none"
                                        :class="recurringDays.includes({{ $index }}) ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                                    >
                                        {{ $dayShort }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="recurringStartTime" class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Saati</label>
                        <select id="recurringStartTime" wire:model="recurringStartTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @for($hour = 8; $hour <= 20; $hour++)
                                @for($min = 0; $min < 60; $min += 30)
                                    @php 
                                        $time = sprintf('%02d:%02d', $hour, $min);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="recurringEndTime" class="block text-sm font-medium text-gray-700 mb-1">Bitiş Saati</label>
                        <select id="recurringEndTime" wire:model="recurringEndTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @for($hour = 8; $hour <= 21; $hour++)
                                @for($min = 0; $min < 60; $min += 30)
                                    @php 
                                        $time = sprintf('%02d:%02d', $hour, $min);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="recurringDuration" class="block text-sm font-medium text-gray-700 mb-1">Randevu Süresi (dk)</label>
                        <select id="recurringDuration" wire:model="recurringDuration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="15">15 dakika</option>
                            <option value="30">30 dakika</option>
                            <option value="45">45 dakika</option>
                            <option value="60">60 dakika</option>
                            <option value="90">90 dakika</option>
                            <option value="120">120 dakika</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="recurringInterval" class="block text-sm font-medium text-gray-700 mb-1">Randevu Arası (dk)</label>
                        <select id="recurringInterval" wire:model="recurringInterval" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="0">Ara yok</option>
                            <option value="5">5 dakika</option>
                            <option value="10">10 dakika</option>
                            <option value="15">15 dakika</option>
                            <option value="30">30 dakika</option>
                        </select>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-3 rounded-md mb-4">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Önizleme</h4>
                    <div class="text-sm text-blue-700">
                        <p>Seçilen günlerde <strong>{{ $recurringStartTime ?? '09:00' }}</strong> ile <strong>{{ $recurringEndTime ?? '17:00' }}</strong> arasında</p>
                        <p><strong>{{ $recurringDuration ?? '30' }}</strong> dakikalık randevular, aralarında <strong>{{ $recurringInterval ?? '0' }}</strong> dakika ara ile oluşturulacak</p>
                        <p class="mt-2">Tekrarlama: <strong>{{ $recurringPattern === 'weekly' ? 'Her hafta' : ($recurringPattern === 'biweekly' ? 'İki haftada bir' : 'Her ay') }}</strong></p>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button 
                        type="button" 
                        wire:click="generatePreviewSlots"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Önizle
                    </button>
                    <button 
                        type="button" 
                        wire:click="applyRecurringSlots"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Şablonu Uygula
                    </button>
                </div>
            </div>
            
            <!-- Recurring template preview -->
            @if(isset($previewSlots) && count($previewSlots) > 0)
            <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Şablon Önizleme</h3>
                
                <div class="space-y-4">
                    @foreach($previewSlots as $day => $slots)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3">
                                <h4 class="font-medium text-gray-900">{{ $dayNames[$day] }}</h4>
                            </div>
                            
                            <div class="px-4 py-3">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach($slots as $slot)
                                        <div class="flex items-center bg-blue-50 px-3 py-2 rounded">
                                            <span class="text-blue-800">{{ $slot }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Saved Templates -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Kayıtlı Şablonlar</h3>
                
                @if(isset($recurringTemplates) && count($recurringTemplates) > 0)
                    <div class="space-y-4">
                        @foreach($recurringTemplates as $index => $template)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between bg-gray-50 px-4 py-3">
                                    <h4 class="font-medium text-gray-900">Şablon #{{ $index + 1 }}</h4>
                                    <div class="flex space-x-2">
                                        <button 
                                            type="button"
                                            wire:click="loadRecurringTemplate({{ $index }})"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                        <button 
                                            type="button"
                                            wire:click="deleteRecurringTemplate({{ $index }})"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="px-4 py-3">
                                    <p class="text-sm text-gray-600 mb-2">
                                        <span class="font-medium">Günler:</span> 
                                        {{ implode(', ', array_map(function($day) use ($dayNames) { 
                                            return $dayNames[$day]; 
                                        }, $template['days'])) }}
                                    </p>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <span class="font-medium">Saat Aralığı:</span> 
                                        {{ $template['startTime'] }} - {{ $template['endTime'] }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Randevu Ayrıntıları:</span> 
                                        {{ $template['duration'] }} dk randevu, {{ $template['interval'] }} dk ara
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Henüz kayıtlı şablon bulunmamaktadır.</p>
                        <p class="text-sm mt-2">Yukarıdan bir şablon oluşturup kaydedebilirsiniz.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Vacation/Off periods section -->
        <div x-data="{ activeTab: 'vacation' }" x-show="activeTab === 'vacation'">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">İzin Dönemi Ekle</h3>
                
                <p class="text-sm text-gray-600 mb-4">İzinde olacağınız, randevu almak istemediğiniz dönemleri belirleyin. Bu dönemlerde tüm randevu saatleri otomatik olarak kapatılacaktır.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="vacationStartDate" class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                        <input 
                            type="date" 
                            id="vacationStartDate" 
                            wire:model="vacationStartDate"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        >
                    </div>
                    
                    <div>
                        <label for="vacationEndDate" class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                        <input 
                            type="date" 
                            id="vacationEndDate" 
                            wire:model="vacationEndDate"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        >
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="vacationNote" class="block text-sm font-medium text-gray-700 mb-1">Not (İsteğe Bağlı)</label>
                    <textarea 
                        id="vacationNote" 
                        wire:model="vacationNote"
                        rows="2"
                        placeholder="İzin sebebi veya hatırlatma notu..."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    ></textarea>
                </div>
                
                <div class="flex items-center mb-4">
                    <input 
                        type="checkbox" 
                        id="notifyPatients" 
                        wire:model="notifyPatients"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="notifyPatients" class="ml-2 block text-sm text-gray-700">
                        Bu dönemde randevusu olan hastalara bildirim gönder
                    </label>
                </div>
                
                <div class="flex justify-end">
                    <button 
                        type="button" 
                        wire:click="addVacationPeriod"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        İzin Dönemi Ekle
                    </button>
                </div>
            </div>
            
            <!-- Active vacation periods -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aktif İzin Dönemleri</h3>
                
                @if(isset($vacationPeriods) && count($vacationPeriods) > 0)
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tarih Aralığı</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Not</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bildirim</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">İşlemler</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($vacationPeriods as $index => $period)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ date('d.m.Y', strtotime($period['startDate'])) }} - {{ date('d.m.Y', strtotime($period['endDate'])) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $period['note'] ?: 'Not yok' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($period['notifyPatients'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Bildirim gönderildi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Bildirim gönderilmedi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <button 
                                                type="button"
                                                wire:click="deleteVacationPeriod({{ $index }})"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                <span class="sr-only">Sil</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Aktif izin dönemi bulunmamaktadır.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> 