<div 
    class="bg-white rounded-lg shadow p-6 overflow-hidden"
    x-data="{ showEditForm: false }"
    x-on:click.away="showEditForm = false"
>
    <div class="flex items-start justify-between">
        <h2 class="text-xl font-orbitron font-medium text-gray-900 mb-4">Profil Bilgileri</h2>
        <button 
            class="text-blue-500 hover:text-blue-700 transition-colors"
            x-on:click="showEditForm = !showEditForm"
            title="Profil bilgilerini düzenle"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
    </div>
    
    <div class="flex items-center mb-6">
        <div class="mr-4">
            <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200">
                <img src="{{ $profilePhoto }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
            </div>
        </div>
        <div>
            <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
            <div class="flex items-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $roleLabel }}
                </span>
                <span class="text-sm text-gray-500 ml-2" title="Son giriş">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $lastLogin }}
                </span>
            </div>
        </div>
    </div>
    
    <!-- Normal Information Display -->
    <div x-show="!showEditForm" class="space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-500">E-posta</label>
            <div class="mt-1 text-gray-900">{{ $user->email }}</div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500">Kayıt Tarihi</label>
            <div class="mt-1 text-gray-900">{{ $user->created_at->format('d.m.Y') }}</div>
        </div>
        <div class="pt-3">
            <a href="/profil/edit" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Profil sayfasına git
            </a>
        </div>
    </div>
    
    <!-- Edit Form (toggled with Alpine.js) -->
    <div x-show="showEditForm" class="space-y-4 mt-4" x-cloak>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">İsim</label>
            <input type="text" id="name" wire:model="user.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
            <input type="email" id="email" wire:model="user.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="flex justify-end space-x-2 pt-3">
            <button 
                type="button" 
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                wire:click="$refresh"
            >
                Güncelle
            </button>
            <button 
                type="button" 
                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                x-on:click="showEditForm = false"
            >
                İptal
            </button>
        </div>
    </div>
    
    <!-- Tooltip/popover with Alpine.js -->
    <div class="mt-4 relative" x-data="{ showTip: false }">
        <div 
            class="text-sm text-gray-500 flex items-center cursor-pointer" 
            x-on:mouseenter="showTip = true" 
            x-on:mouseleave="showTip = false"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Profil bilgilerinizi güncel tutun
        </div>
        <div 
            x-show="showTip" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute left-0 bottom-full mb-2 w-64 rounded-md bg-black text-white text-xs p-2 z-10"
            x-cloak
        >
            Güncel profil bilgileri, hastaların size güvenmesi ve sizi bulması için önemlidir. Lütfen profil fotoğrafınızı ve bilgilerinizi tamamlayın.
        </div>
    </div>
</div> 