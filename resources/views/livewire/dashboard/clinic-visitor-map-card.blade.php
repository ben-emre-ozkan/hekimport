<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Ziyaretçi Haritası</h3>
        <div class="text-sm font-semibold text-gray-900">{{ $totalVisitors }} Ziyaretçi</div>
    </div>
    
    <div class="flex-grow">
        <!-- Map Visualization -->
        <div class="h-44 mb-4" wire:ignore>
            <canvas id="visitorMap"></canvas>
        </div>
        
        <div class="text-sm font-medium text-gray-700 mb-2">En Çok Ziyaret Eden Şehirler</div>
        <div class="space-y-2">
            @foreach($topCities as $index => $city)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $city['city'] }}</span>
                        <span class="text-gray-600">{{ $city['visitors'] }} ziyaretçi</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" 
                            style="width: {{ ($city['visitors'] / $topCities[0]['visitors']) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('vitrinim') }}?tab=analytics" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">
            <span>Ziyaretçi Detayları</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', function () {
            const ctx = document.getElementById('visitorMap').getContext('2d');
            const visitorData = @json($visitorData);
            
            // Load Turkey map image
            const mapImage = new Image();
            mapImage.src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Turkey_administrative_map.svg/1200px-Turkey_administrative_map.svg.png';
            
            mapImage.onload = function() {
                // Create Chart.js bubble chart
                new Chart(ctx, {
                    type: 'bubble',
                    data: {
                        datasets: [{
                            label: 'Ziyaretçi Dağılımı',
                            data: visitorData.map(item => ({
                                x: item.lng,
                                y: item.lat,
                                r: item.radius,
                                city: item.city,
                                visitors: item.visitors
                            })),
                            backgroundColor: 'rgba(102, 126, 234, 0.6)',
                            borderColor: 'rgba(102, 126, 234, 0.8)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(102, 126, 234, 0.8)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.raw.city + ': ' + context.raw.visitors + ' ziyaretçi';
                                    }
                                }
                            },
                            backgroundImage: {
                                image: mapImage
                            }
                        },
                        scales: {
                            x: {
                                min: 26,
                                max: 45,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                }
                            },
                            y: {
                                min: 36,
                                max: 42,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                }
                            }
                        }
                    },
                    plugins: [{
                        id: 'backgroundImage',
                        beforeDraw: (chart) => {
                            const ctx = chart.ctx;
                            const { top, left, width, height } = chart.chartArea;
                            
                            // Draw map image as background
                            ctx.drawImage(mapImage, left, top, width, height);
                        }
                    }]
                });
            };
        });
    </script>
</div> 