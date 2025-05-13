<div class="flex flex-col h-full">
    <div class="flex items-center space-x-3 mb-4">
        <h3 class="text-lg font-medium text-gray-900">Klinik Konumu</h3>
    </div>
    
    @if($hasAddress)
        <div class="flex-grow relative">
            <div id="clinic-map" class="w-full h-full min-h-[160px] rounded-lg overflow-hidden" wire:ignore></div>
        </div>
        
        <div class="mt-3 text-sm text-gray-600 mb-2">
            <div class="font-medium mb-1">Adres:</div>
            <p>{{ $address }}</p>
        </div>
        
        <script>
            document.addEventListener('livewire:initialized', function () {
                function initMap() {
                    const lat = {{ $latitude }};
                    const lng = {{ $longitude }};
                    const mapOptions = {
                        center: { lat, lng },
                        zoom: 15,
                        mapTypeControl: false,
                        streetViewControl: false,
                        fullscreenControl: false
                    };
                    
                    const map = new google.maps.Map(document.getElementById('clinic-map'), mapOptions);
                    
                    const marker = new google.maps.Marker({
                        position: { lat, lng },
                        map: map,
                        title: 'Kliniğiniz'
                    });
                }
                
                // Check if Google Maps API is already loaded
                if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                    // Load Google Maps API script
                    const script = document.createElement('script');
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap';
                    script.async = true;
                    script.defer = true;
                    
                    // Add callback to window object
                    window.initMap = initMap;
                    
                    document.head.appendChild(script);
                } else {
                    // API already loaded, init map directly
                    initMap();
                }
            });
        </script>
    @else
        <div class="flex items-center justify-center flex-grow">
            <div class="text-center">
                <div class="text-purple-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <p class="text-gray-600 mb-3">Klinik adresinizi ekleyin</p>
            </div>
        </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ url('/masam/harita') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-700">
            <span>Harita Ayarlarım</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div> 