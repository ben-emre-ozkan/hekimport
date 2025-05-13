<div class="bg-gray-50 py-6">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-orbitron font-bold mb-6">Vitrin Analizleri</h1>
        
        <!-- Date range selector -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Zaman Aralığı</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Zaman Aralığı Seçimi</label>
                    <select id="dateRange" wire:model="dateRange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="today">Bugün</option>
                        <option value="yesterday">Dün</option>
                        <option value="last_7_days">Son 7 gün</option>
                        <option value="last_30_days">Son 30 gün</option>
                        <option value="this_month">Bu Ay</option>
                        <option value="last_month">Geçen Ay</option>
                        <option value="this_year">Bu Yıl</option>
                        <option value="custom">Özel Aralık</option>
                    </select>
                </div>
                
                <div x-data="{ showCustomRange: @entangle('dateRange').defer === 'custom' }" x-show="showCustomRange" class="flex space-x-4 items-end">
                    <div class="flex-1">
                        <label for="customStartDate" class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                        <input 
                            type="date" 
                            id="customStartDate" 
                            wire:model="customStartDate" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            max="{{ $customEndDate }}"
                        >
                    </div>
                    
                    <div class="flex-1">
                        <label for="customEndDate" class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                        <input 
                            type="date" 
                            id="customEndDate" 
                            wire:model="customEndDate" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            min="{{ $customStartDate }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Visit Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Visits -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Toplam Ziyaretler</h3>
                <div class="flex items-end space-x-2">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($visitStats['total_visits'] ?? 0) }}</div>
                    
                    @if(isset($visitStats['visit_change']))
                        @if($visitStats['visit_change'] > 0)
                            <div class="text-sm font-medium text-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                                {{ $visitStats['visit_change'] }}%
                            </div>
                        @elseif($visitStats['visit_change'] < 0)
                            <div class="text-sm font-medium text-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                {{ abs($visitStats['visit_change']) }}%
                            </div>
                        @else
                            <div class="text-sm font-medium text-gray-500">0%</div>
                        @endif
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-1">Önceki döneme göre</p>
            </div>
            
            <!-- Unique Visitors -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Tekil Ziyaretçiler</h3>
                <div class="flex items-end space-x-2">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($visitStats['unique_visitors'] ?? 0) }}</div>
                    
                    @if(isset($visitStats['visitor_change']))
                        @if($visitStats['visitor_change'] > 0)
                            <div class="text-sm font-medium text-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                                {{ $visitStats['visitor_change'] }}%
                            </div>
                        @elseif($visitStats['visitor_change'] < 0)
                            <div class="text-sm font-medium text-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                {{ abs($visitStats['visitor_change']) }}%
                            </div>
                        @else
                            <div class="text-sm font-medium text-gray-500">0%</div>
                        @endif
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-1">Önceki döneme göre</p>
            </div>
            
            <!-- Bounce Rate -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Hemen Çıkma Oranı</h3>
                <div class="text-3xl font-bold text-gray-900">{{ $visitStats['bounce_rate'] ?? 0 }}%</div>
                <p class="text-sm text-gray-500 mt-1">Tek sayfa ziyaretleri</p>
            </div>
            
            <!-- Average Duration -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Ortalama Süre</h3>
                <div class="text-3xl font-bold text-gray-900">{{ $visitStats['avg_visit_duration'] ?? '0:00' }}</div>
                <p class="text-sm text-gray-500 mt-1">Ziyaret başına</p>
            </div>
        </div>
        
        <!-- Visit Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" x-data="{ init() { this.initChart() }, async initChart() { 
            if (typeof Chart === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                document.head.appendChild(script);
                await new Promise(resolve => script.onload = resolve);
            }
            
            const ctx = document.getElementById('visitsChart').getContext('2d');
            
            if (window.visitsChart) {
                window.visitsChart.destroy();
            }
            
            window.visitsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {{ json_encode($chartData['labels'] ?? []) }},
                    datasets: [{
                        label: 'Ziyaretler',
                        data: {{ json_encode($chartData['data'] ?? []) }},
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        } }" x-init="init">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Ziyaret Trendi</h2>
            <div class="h-80">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>
        
        <!-- Engagement Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Etkileşimler</h2>
                
                <div class="space-y-4">
                    <!-- Appointment Requests -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Randevu Talepleri</h3>
                                <p class="text-xs text-gray-500">Toplam gönderilen talepler</p>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">{{ $engagementStats['appointment_requests'] ?? 0 }}</div>
                    </div>
                    
                    <!-- Call Clicks -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Telefon Tıklamaları</h3>
                                <p class="text-xs text-gray-500">Telefon numaranıza tıklamalar</p>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">{{ $engagementStats['call_clicks'] ?? 0 }}</div>
                    </div>
                    
                    <!-- Email Clicks -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">E-posta Tıklamaları</h3>
                                <p class="text-xs text-gray-500">E-posta adresinize tıklamalar</p>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">{{ $engagementStats['email_clicks'] ?? 0 }}</div>
                    </div>
                    
                    <!-- Social Media Clicks -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Sosyal Medya Tıklamaları</h3>
                                <p class="text-xs text-gray-500">Sosyal medya hesaplarınıza tıklamalar</p>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">{{ $engagementStats['social_clicks'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Hizmet Görüntülenmeleri</h2>
                
                @if(empty($serviceStats))
                    <div class="text-center py-8 text-gray-500">
                        <p>Henüz hizmet görüntüleme verisi bulunmamaktadır.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($serviceStats as $index => $service)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $service['name'] }}</h3>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                            style="width: {{ (max(array_column($serviceStats, 'views')) > 0) ? ($service['views'] / max(array_column($serviceStats, 'views'))) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="ml-4 text-lg font-bold text-gray-900">{{ $service['views'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Geographic Data -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Cities -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-900 mb-4">En Çok Ziyaret Eden Şehirler</h2>
                
                @if(empty($geographicStats['cities']))
                    <div class="text-center py-8 text-gray-500">
                        <p>Henüz şehir bazlı ziyaret verisi bulunmamaktadır.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($geographicStats['cities'] as $city)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $city['city'] }}</h3>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div class="bg-green-600 h-2.5 rounded-full" 
                                            style="width: {{ (!empty($geographicStats['cities']) && isset($geographicStats['cities'][0]['count']) && $geographicStats['cities'][0]['count'] > 0) ? ($city['count'] / $geographicStats['cities'][0]['count']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="ml-4 text-lg font-bold text-gray-900">{{ $city['count'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Countries -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-900 mb-4">En Çok Ziyaret Eden Ülkeler</h2>
                
                @if(empty($geographicStats['countries']))
                    <div class="text-center py-8 text-gray-500">
                        <p>Henüz ülke bazlı ziyaret verisi bulunmamaktadır.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($geographicStats['countries'] as $country)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $country['country'] }}</h3>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div class="bg-purple-600 h-2.5 rounded-full" 
                                            style="width: {{ (!empty($geographicStats['countries']) && isset($geographicStats['countries'][0]['count']) && $geographicStats['countries'][0]['count'] > 0) ? ($country['count'] / $geographicStats['countries'][0]['count']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="ml-4 text-lg font-bold text-gray-900">{{ $country['count'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Devices -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Cihaz Dağılımı</h2>
                
                @if(empty($geographicStats['devices']))
                    <div class="text-center py-8 text-gray-500">
                        <p>Henüz cihaz bazlı ziyaret verisi bulunmamaktadır.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($geographicStats['devices'] as $device)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        @if($device['device_type'] === 'mobile')
                                            Mobil
                                        @elseif($device['device_type'] === 'tablet')
                                            Tablet
                                        @elseif($device['device_type'] === 'desktop')
                                            Masaüstü
                                        @else
                                            {{ $device['device_type'] }}
                                        @endif
                                    </h3>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div class="bg-red-600 h-2.5 rounded-full" 
                                            style="width: {{ (!empty($geographicStats['devices']) && isset($geographicStats['devices'][0]['count']) && $geographicStats['devices'][0]['count'] > 0) ? ($device['count'] / $geographicStats['devices'][0]['count']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="ml-4 text-lg font-bold text-gray-900">{{ $device['count'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Export Options -->
        <div class="flex justify-end space-x-4">
            <button 
                wire:click="exportAsPdf"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                PDF Olarak İndir
            </button>
            <button 
                wire:click="exportAsExcel"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Excel Olarak İndir
            </button>
        </div>
    </div>
</div> 