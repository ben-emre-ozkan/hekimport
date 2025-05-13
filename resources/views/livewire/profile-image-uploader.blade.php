<div>
    <div class="relative">
        @if($vitrin->getFirstMediaUrl('profile_photos'))
            <img src="{{ $vitrin->getFirstMediaUrl('profile_photos') }}" 
                 alt="Profile Photo" 
                 class="w-32 h-32 rounded-full object-cover">
        @else
            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        @endif

        <button type="button" 
                wire:click="$set('photo', null)"
                class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md hover:bg-gray-100">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
    </div>

    @if($showCropper)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-4 max-w-2xl w-full">
                <div class="mb-4">
                    <img id="cropper" 
                         src="{{ $photo->temporaryUrl() }}" 
                         class="max-w-full h-auto">
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" 
                            wire:click="cancelCrop"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="button" 
                            wire:click="crop"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Crop & Save
                    </button>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script>
            document.addEventListener('livewire:initialized', function () {
                const image = document.getElementById('cropper');
                const cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    restore: false,
                    modal: true,
                    guides: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    crop: function(event) {
                        @this.set('cropData', {
                            x: event.detail.x,
                            y: event.detail.y,
                            width: event.detail.width,
                            height: event.detail.height,
                            rotate: event.detail.rotate,
                            scaleX: event.detail.scaleX,
                            scaleY: event.detail.scaleY
                        });
                    }
                });
            });
        </script>
        @endpush
    @endif
</div> 