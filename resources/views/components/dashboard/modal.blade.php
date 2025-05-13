@props(['id', 'maxWidth' => 'md', 'closeable' => true])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    '6xl' => 'sm:max-w-6xl',
    '7xl' => 'sm:max-w-7xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: false }"
    x-on:open-modal.window="$event.detail == '{{ $id }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $id }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    style="display: none;"
>
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 transform backdrop-blur-sm bg-black/30" 
        x-on:click="show = false"
    ></div>

    <div
        x-show="show"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
    >
        <div class="relative p-6">
            @if ($closeable)
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
            
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ $title ?? '' }}
                </h3>
            </div>
            
            <div>
                {{ $slot }}
            </div>
            
            @if (isset($footer))
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 flex justify-end space-x-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    window.openModal = function(modalId) {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: modalId }))
    }
    
    window.closeModal = function(modalId) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: modalId }))
    }
</script> 