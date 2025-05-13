<div>
    @if($message)
        <form wire:submit.prevent="updateMessage">
            <div class="space-y-4">
                <div>
                    <label for="edit_message_content_{{ $messageId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 georgia-font">{{ __('Mesaj İçeriği') }}</label>
                    <textarea wire:model.defer="content" id="edit_message_content_{{ $messageId }}" rows="8" 
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                              style="font-family: Verdana, Arial, sans-serif; font-size: 14px; box-shadow: 1px 1px 2px rgba(0,0,0,0.1);"></textarea>
                    @error('content') <span class="text-red-500 text-xs italic georgia-font">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="$dispatch('closeModal')" type="button" class="mr-2">
                    {{ __('Vazgeç') }}
                </x-secondary-button>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 georgia-font"
                        style="background-color: #00c8b3; box-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                    <span wire:loading wire:target="updateMessage" class="mr-1">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    {{ __('Mesajı Güncelle') }}
                </button>
            </div>
        </form>
    @else
        <p class="text-red-500 georgia-font">{{ __('Düzenlenecek mesaj yüklenemedi veya bulunamadı.') }}</p>
    @endif
</div>
