@props(['services'])

<section class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-900">Hizmetler</h2>
        <div class="relative">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Hizmet ara..."
                   class="w-64 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    <div class="space-y-6">
        @foreach($services as $service)
            <div class="border-b border-gray-200 pb-6 last:border-0">
                <h3 class="text-xl font-semibold text-gray-900">{{ $service['name'] }}</h3>
                <p class="mt-2 text-gray-600">{{ $service['description'] }}</p>
                <p class="mt-2 text-lg font-medium text-blue-600">{{ $service['price'] }} TL</p>
            </div>
        @endforeach
    </div>
</section> 