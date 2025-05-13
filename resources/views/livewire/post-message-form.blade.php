<div class="mt-6 pt-4 border-t border-gray-300 dark:border-gray-700">
    <form wire:submit.prevent="save" x-data="{ 
        initQuotes: function() {
            const component = this;
            window.addEventListener('quote-message', function(event) {
                const quoteText = '> ' + event.detail.content.split('\n').join('\n> ');
                const citation = event.detail.author + ' yazdı:';
                const currentContent = component.$wire.get('content') || '';
                const newContent = currentContent + 
                    (currentContent ? '\n\n' : '') + 
                    citation + '\n' + quoteText + '\n\n';
                component.$wire.set('content', newContent);
                component.$refs.messageTextarea.focus();
            });
        }
    }" x-init="initQuotes()">
        @if (session()->has('error'))
            <div class="mb-2 p-3 rounded-md bg-red-100 text-red-700 forum-heading">
                {{ session('error') }}
            </div>
        @endif
        <div>
            <label for="message_content_{{ $topicId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 forum-heading">{{ __('Mesajınız') }}</label>
            <textarea 
                wire:model.defer="content" 
                id="message_content_{{ $topicId }}" 
                rows="4" 
                x-ref="messageTextarea"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm forum-text"
                placeholder="{{ __('Mesajınızı buraya yazın...') }}"
                dusk="message-content-input"
            ></textarea>
            @error('content') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        </div>
        <div class="mt-3 text-right">
            <button 
                type="submit" 
                class="forum-button inline-flex justify-center py-2 px-4 rounded-md text-white text-sm"
                dusk="message-submit-button"
            >
                <span wire:loading wire:target="save" class="mr-1" dusk="loading-indicator">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                {{ __('Gönder') }}
            </button>
        </div>
    </form>
</div>
