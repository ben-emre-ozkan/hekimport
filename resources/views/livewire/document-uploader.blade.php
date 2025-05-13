<div>
    <div class="space-y-4">
        @foreach($vitrin->getMedia('documents') as $media)
            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-gray-100 rounded">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">{{ $media->name }}</h3>
                        @if($media->getCustomProperty('description'))
                            <p class="text-sm text-gray-500">{{ $media->getCustomProperty('description') }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ $media->getUrl() }}" 
                       target="_blank"
                       class="p-2 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    <button type="button"
                            wire:click="removeDocument({{ $media->id }})"
                            class="p-2 text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach

        <button type="button"
                wire:click="$set('showUploader', true)"
                class="w-full p-4 border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-gray-400">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <span class="mt-2 block text-sm font-medium text-gray-900">Add Document</span>
        </button>
    </div>

    @if($showUploader)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-4 max-w-2xl w-full">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" 
                               wire:model="title"
                               id="title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description"
                                id="description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700">Document</label>
                        <input type="file" 
                               wire:model="document"
                               id="document"
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" 
                            wire:click="$set('showUploader', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="button" 
                            wire:click="saveDocument"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Upload Document
                    </button>
                </div>
            </div>
        </div>
    @endif
</div> 