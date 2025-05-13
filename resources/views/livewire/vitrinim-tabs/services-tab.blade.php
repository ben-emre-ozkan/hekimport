<div>
    <h2 class="text-xl font-medium text-gray-900 mb-6">{{ __('vitrinim.services.title') }}</h2>
    
    <p class="text-gray-600 mb-6">{{ __('vitrinim.services.description') }}</p>
    
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('vitrinim.services.add') }}</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="newServiceName" class="block text-sm font-medium text-gray-700 mb-1">{{ __('vitrinim.services.name') }}</label>
                <input type="text" id="newServiceName" wire:model.live="newServiceName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            
            <div>
                <label for="newServiceCategory" class="block text-sm font-medium text-gray-700 mb-1">{{ __('vitrinim.services.category') }}</label>
                <select id="newServiceCategory" wire:model.live="newServiceCategory" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">{{ __('vitrinim.services.select_category') }}</option>
                    @foreach(__('vitrinim.services.categories') as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="md:col-span-2">
                <label for="newServiceDescription" class="block text-sm font-medium text-gray-700 mb-1">{{ __('vitrinim.services.description') }}</label>
                <input type="text" id="newServiceDescription" wire:model.live="newServiceDescription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            
            <div>
                <label for="newServicePrice" class="block text-sm font-medium text-gray-700 mb-1">{{ __('vitrinim.services.price') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">₺</span>
                    </div>
                    <input type="text" id="newServicePrice" wire:model.live="newServicePrice" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="0.00">
                </div>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end">
            <button 
                type="button" 
                wire:click="addService"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('vitrinim.services.add') }}
            </button>
        </div>
    </div>
    
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('vitrinim.services.title') }}</h3>
        
        <div x-data="serviceManager()" x-init="initServiceDragAndDrop()" class="space-y-4">
            @if(count($services ?? []) > 0)
                <!-- Group services by category -->
                @php
                    $groupedServices = collect($services)->groupBy('category');
                    if($groupedServices->has('')) {
                        $groupedServices->put('general', $groupedServices->get(''));
                        $groupedServices->forget('');
                    }
                @endphp

                @foreach($groupedServices as $category => $categoryServices)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3 capitalize border-b pb-2">
                            {{ __('vitrinim.services.categories.'.$category, ['default' => ucfirst($category)]) }}
                        </h4>
                        
                        <div class="service-group space-y-3" data-category="{{ $category }}">
                            @foreach($categoryServices as $index => $service)
                                <div 
                                    class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition-shadow duration-200 cursor-move"
                                    draggable="true"
                                    data-index="{{ array_search($service, $services) }}"
                                    x-ref="serviceItem{{ array_search($service, $services) }}"
                                    @dragstart="dragStart($event, {{ array_search($service, $services) }})"
                                    @dragover.prevent
                                    @dragenter.prevent
                                    @drop="drop($event, {{ array_search($service, $services) }})"
                                >
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center">
                                                <h5 class="font-medium text-gray-900">{{ $service['name'] }}</h5>
                                                @if(!empty($service['price']))
                                                    <span class="text-sm font-semibold text-green-600">₺{{ $service['price'] }}</span>
                                                @endif
                                            </div>
                                            @if(!empty($service['description']))
                                                <p class="text-sm text-gray-500 mt-1">{{ $service['description'] }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center ml-4">
                                            <span class="mr-2 px-2 py-1 bg-gray-100 text-xs rounded-full text-gray-600 capitalize">
                                                {{ __('vitrinim.services.categories.'.$service['category'], ['default' => ucfirst($service['category'] ?: 'general')]) }}
                                            </span>
                                            <button
                                                type="button"
                                                wire:click="removeService({{ array_search($service, $services) }})"
                                                class="text-red-500 hover:text-red-700"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-5 0h10" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-6 bg-gray-50 rounded-lg border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500">{{ __('vitrinim.services.no_services') }}</p>
                </div>
            @endif
        </div>
    </div>
    
    @if(count($services ?? []) > 0)
        <div class="mt-6 flex justify-end">
            <button 
                type="button" 
                wire:click="saveServices"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <svg wire:loading wire:target="saveServices" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('vitrinim.services.submit') }}</span>
            </button>
        </div>
    @endif
</div>

<script>
function serviceManager() {
    return {
        dragIndex: null,
        
        initServiceDragAndDrop() {
            // Initialize drag and drop functionality
        },
        
        dragStart(event, index) {
            this.dragIndex = index;
            event.dataTransfer.effectAllowed = 'move';
        },
        
        drop(event, index) {
            if(this.dragIndex === null) return;
            
            // Tell Livewire to reorder the services
            @this.call('reorderServices', this.dragIndex, index);
            
            this.dragIndex = null;
        }
    }
}
</script> 