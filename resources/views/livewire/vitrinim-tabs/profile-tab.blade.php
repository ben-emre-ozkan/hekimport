<div>
    <h2 class="text-xl font-medium text-gray-900 mb-6">Profil Bilgileri</h2>
    
    <form wire:submit.prevent="saveProfile" class="space-y-6">
        <!-- Basic Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                <input type="text" id="title" wire:model.live="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="specialty" class="block text-sm font-medium text-gray-700 mb-1">Uzmanlık Alanı</label>
                <select id="specialty" wire:model.live="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Uzmanlık Alanı Seçin</option>
                    @foreach($dentalSpecialties as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('specialty') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <!-- Contact Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="contact_info.phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                <input type="tel" id="contact_info.phone" wire:model.live="contact_info.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('contact_info.phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="contact_info.email" class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                <input type="email" id="contact_info.email" wire:model.live="contact_info.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('contact_info.email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <!-- Location Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Şehir</label>
                <input type="text" id="city" wire:model.live="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                <input type="text" id="address" wire:model.live="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <!-- Description & Bio Section -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Kısa Açıklama</label>
            <textarea id="description" wire:model.live="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            <p class="mt-1 text-xs text-gray-500">SEO ve listelerde görünecek kısa açıklama (160 karakter)</p>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        
        <!-- Rich Text Bio Editor -->
        <div 
            x-data="{ 
                content: @entangle('bio').live,
                isBold: false,
                isItalic: false,
                isUnderline: false,
                init() {
                    this.$refs.bioEditor.innerHTML = this.content;
                    this.$watch('content', () => {
                        if (this.$refs.bioEditor.innerHTML !== this.content) {
                            this.$refs.bioEditor.innerHTML = this.content;
                        }
                    });
                },
                updateContent() {
                    this.content = this.$refs.bioEditor.innerHTML;
                },
                format(command) {
                    document.execCommand(command, false, null);
                    this.updateContent();
                    this.$refs.bioEditor.focus();
                }
            }"
            class="space-y-2"
        >
            <label class="block text-sm font-medium text-gray-700 mb-1">Biyografi</label>
            
            <!-- Rich Text Toolbar -->
            <div class="flex space-x-2 p-2 bg-gray-50 border border-gray-300 rounded-t-md">
                <button 
                    type="button" 
                    @click="format('bold')" 
                    :class="{'bg-blue-100': isBold}"
                    class="p-1 rounded hover:bg-gray-200"
                    title="Kalın"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11h8v1a4 4 0 01-4 4H8a4 4 0 01-4-4V6a4 4 0 014-4h4a4 4 0 014 4v4" />
                    </svg>
                </button>
                <button 
                    type="button" 
                    @click="format('italic')" 
                    :class="{'bg-blue-100': isItalic}"
                    class="p-1 rounded hover:bg-gray-200"
                    title="İtalik"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6" />
                    </svg>
                </button>
                <button 
                    type="button" 
                    @click="format('underline')" 
                    :class="{'bg-blue-100': isUnderline}"
                    class="p-1 rounded hover:bg-gray-200"
                    title="Altı çizili"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17h8M8 4v6a4 4 0 008 0V4" />
                    </svg>
                </button>
                <div class="border-l border-gray-300 h-6 mx-1"></div>
                <button 
                    type="button" 
                    @click="format('insertUnorderedList')" 
                    class="p-1 rounded hover:bg-gray-200"
                    title="Madde işaretleri"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <button 
                    type="button" 
                    @click="format('insertOrderedList')" 
                    class="p-1 rounded hover:bg-gray-200"
                    title="Numaralı liste"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
            </div>
            
            <!-- Rich Text Editor -->
            <div 
                x-ref="bioEditor"
                contenteditable="true"
                @input="updateContent"
                @blur="updateContent"
                class="border border-gray-300 rounded-b-md p-3 min-h-[150px] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            ></div>
            
            <p class="mt-1 text-xs text-gray-500">Eğitim, deneyim ve uzmanlıklarınızı içeren detaylı biyografi</p>
            @error('bio') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        
        <!-- Social Media Section -->
        <div x-data="{ open: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Sosyal Medya</h3>
                <button 
                    type="button"
                    @click="open = !open"
                    class="text-blue-600 hover:text-blue-800"
                >
                    <span x-show="!open">Göster</span>
                    <span x-show="open">Gizle</span>
                </button>
            </div>
            
            <div x-show="open" class="mt-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="social_media.facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">facebook.com/</span>
                            <input type="text" id="social_media.facebook" wire:model.live="social_media.facebook" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="social_media.instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">instagram.com/</span>
                            <input type="text" id="social_media.instagram" wire:model.live="social_media.instagram" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="social_media.twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">twitter.com/</span>
                            <input type="text" id="social_media.twitter" wire:model.live="social_media.twitter" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="social_media.linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">linkedin.com/in/</span>
                            <input type="text" id="social_media.linkedin" wire:model.live="social_media.linkedin" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Photo Section -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Profil Fotoğrafı</label>
            
            <div class="flex items-start space-x-6">
                <!-- Current photo -->
                <div class="flex-shrink-0">
                    @if($vitrin->exists && $vitrin->hasMedia('profile_photos'))
                        <img src="{{ $vitrin->getFirstMediaUrl('profile_photos', 'medium') }}" alt="Profil Fotoğrafı" class="h-32 w-32 rounded-full object-cover">
                    @else
                        <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Upload new photo -->
                <div>
                    <div 
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label for="profilePhoto" class="cursor-pointer block text-sm font-medium text-gray-700 mb-1">
                            Fotoğraf yükle
                        </label>
                        <input 
                            type="file" 
                            id="profilePhoto" 
                            wire:model.live="profilePhoto" 
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"
                            accept="image/*"
                        >
                        @error('profilePhoto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        
                        <!-- Progress bar -->
                        <div x-show="isUploading" class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                        </div>
                        
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, WEBP, 2MB max.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                wire:loading.attr="disabled"
                wire:target="saveProfile, profilePhoto"
            >
                <svg wire:loading wire:target="saveProfile" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Profil Bilgilerini Kaydet</span>
            </button>
        </div>
    </form>
</div> 