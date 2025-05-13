<div>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 forum-heading">{{ __('Yeni Başlık Oluştur') }}</h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 forum-text">{{ __('Lütfen yeni forum başlığınız için ayrıntıları girin.') }}</p>

    <form wire:submit.prevent="save" class="mt-4">
        @if (session()->has('message'))
            <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700 georgia-font">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-3 rounded-md bg-red-100 text-red-700 georgia-font">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-4">
            <x-label for="category" value="{{ __('Kategori') }}" class="forum-heading" />
            <select 
                wire:model.defer="categoryId" 
                id="category" 
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm forum-text"
                dusk="topic-category-select"
            >
                <option value="">{{ __('Kategori Seçin') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error for="categoryId" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="title" value="{{ __('Başlık') }}" class="forum-heading" />
            <x-input 
                id="title" 
                type="text" 
                class="mt-1 block w-full forum-text" 
                wire:model.defer="title"
                dusk="topic-title-input"
            />
            <x-input-error for="title" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="content" value="{{ __('İlk Mesaj') }}" class="forum-heading" />
            <div class="mt-1 border border-gray-300 dark:border-gray-700 rounded-md overflow-hidden">
                <!-- Rich Text Editor Toolbar -->
                <div class="bg-gray-100 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700 p-2 flex flex-wrap gap-1">
                    <button type="button" onclick="insertMarkdown('**', '**')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Kalın">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 1 0 0-8H6v8zm0 0v8h8a4 4 0 1 0 0-8H6z"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('_', '_')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="İtalik">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('### ', '')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Başlık">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('- ', '')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Liste">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('[', '](URL)')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('![alt text](', ')')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Resim">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="insertMarkdown('```\n', '\n```')" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700" title="Kod">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </button>
                </div>
                
                <textarea 
                    id="content" 
                    class="w-full border-0 p-3 h-64 focus:ring-0 forum-text dark:bg-gray-900 dark:text-gray-300"
                    wire:model.defer="content" 
                    rows="10"
                    placeholder="Mesajınızı yazın (Markdown desteklenir)"
                    dusk="topic-content-input"
                ></textarea>
            </div>
            
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Markdown desteği: <code>**kalın**</code>, <code>_italik_</code>, <code>### başlık</code>, <code>- liste</code>
            </div>
            
            <x-input-error for="content" class="mt-2" />
        </div>

        <div class="mt-5 flex justify-end">
            <x-button class="forum-button" type="submit" dusk="topic-submit-button">
                {{ __('Kaydet') }}
            </x-button>
        </div>
    </form>
    
    <script>
        function insertMarkdown(prefix, suffix) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selection = textarea.value.substring(start, end);
            const replacement = prefix + selection + suffix;
            
            textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
            
            // Update Livewire model
            const event = new Event('input', { bubbles: true });
            textarea.dispatchEvent(event);
            
            // Reset cursor position
            textarea.focus();
            const newCursorPos = start + prefix.length + selection.length + suffix.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
        }
    </script>
</div>
