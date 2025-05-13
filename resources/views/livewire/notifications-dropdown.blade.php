<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button 
        type="button"
        class="relative p-2 text-white hover:bg-white/10 rounded-full focus:outline-none"
        @click="open = !open"
    >
        <!-- Notification icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        <!-- Unread badge -->
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-600 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown menu -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 z-50 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden"
        style="display: none;"
    >
        <div class="py-2">
            <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900">Bildirimler</h3>
                @if($unreadCount > 0)
                    <button 
                        wire:click="markAllAsRead"
                        class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                    >
                        Tümünü okundu işaretle
                    </button>
                @endif
            </div>
            
            <div class="max-h-64 overflow-y-auto">
                @forelse($notifications as $notification)
                    <div 
                        wire:key="notification-{{ $notification['id'] }}"
                        class="py-2 px-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $notification['read'] ? 'opacity-70' : 'bg-blue-50' }}"
                    >
                        <div class="flex items-start">
                            <!-- Icon based on notification type -->
                            <div class="flex-shrink-0 mr-3">
                                @if($notification['type'] === 'appointment')
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @elseif($notification['type'] === 'message')
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <!-- Notification content -->
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification['message'] }}</p>
                                    @if(!$notification['read'])
                                        <button 
                                            wire:click="markAsRead({{ $notification['id'] }})"
                                            class="ml-2 text-xs text-blue-600 hover:text-blue-800"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $notification['time'] }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 px-4 text-center text-sm text-gray-500">
                        Bildirim bulunmuyor
                    </div>
                @endforelse
            </div>
            
            <div class="py-2 px-4 border-t border-gray-100 text-center">
                <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Tüm bildirimleri görüntüle</a>
            </div>
        </div>
    </div>
</div> 