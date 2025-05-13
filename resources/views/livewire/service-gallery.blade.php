<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($vitrin->getMedia('gallery') as $media)
            <div class="relative group">
                <img src="{{ $media->getUrl() }}" 
                     alt="{{ $media->name }}"
                     class="w-full h-48 object-cover rounded-lg">
                
                <button type="button"
                        wire:click="removePhoto({{ $media->id }})"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endforeach

        <div class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center h-48">
            <button type="button"
                    wire:click="$set('showUploader', true)"
                    class="text-gray-500 hover:text-gray-700">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="mt-2 block text-sm">Add Photos</span>
            </button>
        </div>
    </div>

    @if($showUploader)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-4 max-w-2xl w-full">
                <div class="mb-4">
                    <input type="file" 
                           wire:model="photos" 
                           multiple 
                           accept="image/*"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100">
                </div>

                @if($photos)
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($photos as $photo)
                            <div class="relative">
                                <img src="{{ $photo->temporaryUrl() }}" 
                                     alt="Preview" 
                                     class="w-full h-32 object-cover rounded">
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-end space-x-2">
                    <button type="button" 
                            wire:click="$set('showUploader', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="button" 
                            wire:click="savePhotos"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Upload Photos
                    </button>
                </div>
            </div>
        </div>
    @endif
</div> 