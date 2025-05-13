<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Profil Görüntülenmeleri</h3>
        <div class="flex items-center">
            <span class="text-sm font-semibold {{ $weeklyChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $weeklyChange >= 0 ? '+' : '' }}{{ $weeklyChange }}%
            </span>
            <span class="text-xs text-gray-500 ml-1">haftalık</span>
        </div>
    </div>
    
    <div class="bg-blue-50 rounded-lg p-4 text-center mb-4">
        <div class="text-3xl font-bold text-blue-600">{{ $totalViews }}</div>
        <div class="text-sm font-medium text-gray-600">Toplam Görüntülenme</div>
    </div>
    
    <div class="flex-grow">
        <!-- Chart Area -->
        <div class="h-32 mb-4" wire:ignore>
            <canvas id="viewsChart"></canvas>
        </div>
        
        <!-- Popular Pages -->
        <div class="space-y-3">
            <div class="text-sm font-medium text-gray-700">Popüler Sayfalar</div>
            
            @foreach($popularPages as $page)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $page['name'] }}</span>
                        <span class="text-gray-600">{{ $page['views'] }} görüntülenme</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-teal-500 h-2 rounded-full" style="width: {{ $page['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('vitrinim') }}?tab=analytics" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
            <span>Ayrıntılı Analitik</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', function () {
            const ctx = document.getElementById('viewsChart').getContext('2d');
            
            // Extract data for chart
            const labels = @json(array_column($dailyViews, 'day'));
            const data = @json(array_column($dailyViews, 'count'));
            
            // Create gradient fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 150);
            gradient.addColorStop(0, 'rgba(0, 153, 229, 0.3)');
            gradient.addColorStop(1, 'rgba(0, 200, 179, 0.05)');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Görüntülenme',
                        data: data,
                        borderColor: '#0099e5',
                        borderWidth: 2,
                        pointBackgroundColor: '#0099e5',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true,
                        backgroundColor: gradient
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
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 10,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [3, 3]
                            },
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        });
    </script>
</div> 