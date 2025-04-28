<div>
    <style>
        /* Add styles similar to Prompt 2 */
        .form-input, .form-textarea, .form-select {
            @apply block w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }
        .btn-primary {
            @apply inline-flex items-center justify-center px-6 py-2 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-teal-500 to-blue-500 hover:from-teal-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all;
        }
        .card {
            @apply bg-white shadow-md rounded-xl p-6 mb-6;
        }
        .heading {
            font-family: 'Poppins', sans-serif; @apply text-xl font-semibold text-gray-800 mb-4;
        }
    </style>

    <form wire:submit.prevent="save" class="space-y-8">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Temel Bilgiler -->
        <div class="card">
            <h3 class="heading">Temel Bilgiler</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="subdomain" class="form-label">Vitrin Adresiniz (Subdomain)</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" wire:model.lazy="subdomain" id="subdomain" class="form-input rounded-none rounded-l-md flex-1 min-w-0 block w-full px-3 py-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm border-gray-300 @error('subdomain') border-red-500 @enderror" placeholder="ornk-dr-ahmet">
                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">.hekimport.com</span>
                      </div>
                    <p class="mt-1 text-sm text-gray-500">Vitrin adresiniz benzersiz olmalı ve sadece küçük harf, rakam ve tire içermelidir.</p>
                    @error('subdomain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="photo" class="form-label">Profil Fotoğrafı</label>
                    <input type="file" wire:model="photo" id="photo" class="form-input py-1.5 @error('photo') border-red-500 @enderror">
                    @if ($photo)
                        <p class="mt-2 text-sm text-gray-600">Yeni fotoğraf yüklendi:</p>
                        <img src="{{ $photo->temporaryUrl() }}" alt="Yeni Profil Fotoğrafı Önizleme" class="mt-2 h-24 w-24 rounded-full object-cover">
                    @elseif ($profilePhotoUrl)
                        <p class="mt-2 text-sm text-gray-600">Mevcut Fotoğraf:</p>
                        <img src="{{ $profilePhotoUrl }}" alt="Mevcut Profil Fotoğrafı" class="mt-2 h-24 w-24 rounded-full object-cover">
                    @else
                         <p class="mt-2 text-sm text-gray-600">Henüz profil fotoğrafı yüklenmedi.</p>
                    @endif
                     <div wire:loading wire:target="photo" class="mt-2 text-sm text-gray-500">Yükleniyor...</div>
                    @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    {{-- TODO: Add Laravel Filemanager integration via modal --}}
                </div>
            </div>
        </div>

        <!-- Hakkında -->
        <div class="card">
            <h3 class="heading">Hakkında</h3>
             <div>
                <label for="bio" class="form-label">Biyografi / Hakkımda Yazısı</label>
                <textarea wire:model.lazy="bio" id="bio" rows="4" class="form-textarea @error('bio') border-red-500 @enderror" placeholder="Kendinizi ve kliniğinizi tanıtın..."></textarea>
                @error('bio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Konum ve Uzmanlık -->
        <div class="card">
             <h3 class="heading">Konum ve Uzmanlık Alanları</h3>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="city" class="form-label">Şehir</label>
                    <input type="text" wire:model.lazy="city" id="city" class="form-input @error('city') border-red-500 @enderror" placeholder="Örn: İstanbul">
                    @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                 <div>
                    <label for="address" class="form-label">Adres</label>
                    <input type="text" wire:model.lazy="address" id="address" class="form-input @error('address') border-red-500 @enderror" placeholder="Açık adresiniz">
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
             <div class="mt-6">
                <label for="specialties" class="form-label">Uzmanlık Alanları</label>
                <input type="text" wire:model.lazy="specialties" id="specialties" class="form-input @error('specialties') border-red-500 @enderror" placeholder="Virgülle ayırarak yazınız (Örn: İmplantoloji, Pedodonti)">
                 <p class="mt-1 text-sm text-gray-500">Lütfen uzmanlık alanlarınızı virgülle ayırarak giriniz.</p>
                @error('specialties') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
             <div class="mt-6">
                <label for="services" class="form-label">Sunulan Hizmetler</label>
                <input type="text" wire:model.lazy="services" id="services" class="form-input @error('services') border-red-500 @enderror" placeholder="Virgülle ayırarak yazınız (Örn: Diş Beyazlatma, Kanal Tedavisi)">
                 <p class="mt-1 text-sm text-gray-500">Lütfen sunduğunuz hizmetleri virgülle ayırarak giriniz.</p>
                @error('services') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Çalışma Saatleri -->
        <div class="card">
            <h3 class="heading">Çalışma Saatleri</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($working_hours as $day => $time)
                    <div>
                        <label for="working_hours_{{ $loop->index }}" class="form-label">{{ $day }}</label>
                        <input type="text" wire:model.lazy="working_hours.{{ $day }}" id="working_hours_{{ $loop->index }}" class="form-input" placeholder="Örn: 09:00 - 18:00 veya Kapalı">
                         @error('working_hours.'.$day) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <!-- İletişim ve Sosyal Medya -->
        <div class="card">
            <h3 class="heading">İletişim ve Sosyal Medya</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_phone" class="form-label">Telefon Numarası</label>
                    <input type="tel" wire:model.lazy="contact_info.phone" id="contact_phone" class="form-input @error('contact_info.phone') border-red-500 @enderror" placeholder="0XXXXXXXXXX">
                    @error('contact_info.phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="contact_email" class="form-label">E-posta Adresi</label>
                    <input type="email" wire:model.lazy="contact_info.email" id="contact_email" class="form-input @error('contact_info.email') border-red-500 @enderror" placeholder="iletisim@email.com">
                    @error('contact_info.email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="social_instagram" class="form-label">Instagram URL</label>
                    <input type="url" wire:model.lazy="social_media.instagram" id="social_instagram" class="form-input @error('social_media.instagram') border-red-500 @enderror" placeholder="https://instagram.com/kullaniciadi">
                    @error('social_media.instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="social_linkedin" class="form-label">LinkedIn URL</label>
                    <input type="url" wire:model.lazy="social_media.linkedin" id="social_linkedin" class="form-input @error('social_media.linkedin') border-red-500 @enderror" placeholder="https://linkedin.com/in/kullaniciadi">
                    @error('social_media.linkedin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Kaydet Butonu -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="btn-primary">
                 <div wire:loading wire:target="save" class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                <span wire:loading.remove wire:target="save">Vitrini Kaydet</span>
                <span wire:loading wire:target="save">Kaydediliyor...</span>
            </button>
        </div>
    </form>
</div>
