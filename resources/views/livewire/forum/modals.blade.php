<!-- Create Topic Modal -->
<x-dialog-modal wire:model.defer="showCreateTopicModal">
    <x-slot name="title">
        <span class="text-gray-800">{{ __('Yeni Başlık Oluştur') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="categoryId" value="{{ __('Kategori') }}" />
                <select 
                    id="categoryId"
                    wire:model.defer="topicCategoryId" 
                    class="mt-1 block w-full border-gray-300 focus:border-[#00c8b3] focus:ring focus:ring-[#00c8b3] focus:ring-opacity-50 rounded-md shadow-sm"
                >
                    <option value="">{{ __('Kategori Seçin') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="topicCategoryId" class="mt-2" />
            </div>

            <div>
                <x-label for="topicTitle" value="{{ __('Başlık') }}" />
                <x-input 
                    id="topicTitle" 
                    type="text" 
                    class="mt-1 block w-full" 
                    wire:model.defer="topicTitle" 
                    placeholder="{{ __('Başlık giriniz...') }}"
                    maxlength="100"
                />
                <x-input-error for="topicTitle" class="mt-2" />
            </div>

            <div>
                <x-label for="initialMessage" value="{{ __('İlk Mesaj') }}" />
                <textarea 
                    id="initialMessage" 
                    rows="5" 
                    class="mt-1 block w-full border-gray-300 focus:border-[#00c8b3] focus:ring focus:ring-[#00c8b3] focus:ring-opacity-50 rounded-md shadow-sm" 
                    wire:model.defer="initialMessage"
                    placeholder="{{ __('Mesajınızı giriniz...') }}"
                ></textarea>
                <x-input-error for="initialMessage" class="mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showCreateTopicModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-button wire:click="createTopic" wire:loading.attr="disabled" class="bg-gradient-to-r from-[#00c8b3] to-[#0099e5]">
                {{ __('Oluştur') }}
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>

<!-- Edit Topic Modal -->
<x-dialog-modal wire:model.defer="showEditTopicModal">
    <x-slot name="title">
        <span class="text-gray-800">{{ __('Başlığı Düzenle') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="editTopicCategoryId" value="{{ __('Kategori') }}" />
                <select 
                    id="editTopicCategoryId"
                    wire:model.defer="editTopicCategoryId" 
                    class="mt-1 block w-full border-gray-300 focus:border-[#00c8b3] focus:ring focus:ring-[#00c8b3] focus:ring-opacity-50 rounded-md shadow-sm"
                >
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="editTopicCategoryId" class="mt-2" />
            </div>

            <div>
                <x-label for="editTopicTitle" value="{{ __('Başlık') }}" />
                <x-input 
                    id="editTopicTitle" 
                    type="text" 
                    class="mt-1 block w-full" 
                    wire:model.defer="editTopicTitle" 
                    placeholder="{{ __('Başlık giriniz...') }}"
                    maxlength="100"
                />
                <x-input-error for="editTopicTitle" class="mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showEditTopicModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-button wire:click="updateTopic" wire:loading.attr="disabled" class="bg-gradient-to-r from-[#00c8b3] to-[#0099e5]">
                {{ __('Güncelle') }}
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>

<!-- Edit Message Modal -->
<x-dialog-modal wire:model.defer="showEditMessageModal">
    <x-slot name="title">
        <span class="text-gray-800">{{ __('Mesajı Düzenle') }}</span>
    </x-slot>

    <x-slot name="content">
        <div>
            <x-label for="editMessageContent" value="{{ __('Mesaj') }}" />
            <textarea 
                id="editMessageContent" 
                rows="5" 
                class="mt-1 block w-full border-gray-300 focus:border-[#00c8b3] focus:ring focus:ring-[#00c8b3] focus:ring-opacity-50 rounded-md shadow-sm" 
                wire:model.defer="editMessageContent"
                placeholder="{{ __('Mesajınızı giriniz...') }}"
            ></textarea>
            <x-input-error for="editMessageContent" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showEditMessageModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-button wire:click="updateMessage" wire:loading.attr="disabled" class="bg-gradient-to-r from-[#00c8b3] to-[#0099e5]">
                {{ __('Güncelle') }}
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>

<!-- Delete Confirmations -->
<x-confirmation-modal wire:model.defer="showConfirmDeleteTopicModal">
    <x-slot name="title">
        <span class="text-red-600">{{ __('Başlığı Sil') }}</span>
    </x-slot>

    <x-slot name="content">
        {{ __('Bu başlığı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz ve tüm mesajlar da silinecektir.') }}
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showConfirmDeleteTopicModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-danger-button wire:click="deleteTopic" wire:loading.attr="disabled">
                {{ __('Sil') }}
            </x-danger-button>
        </div>
    </x-slot>
</x-confirmation-modal>

<x-confirmation-modal wire:model.defer="showConfirmDeleteMessageModal">
    <x-slot name="title">
        <span class="text-red-600">{{ __('Mesajı Sil') }}</span>
    </x-slot>

    <x-slot name="content">
        {{ __('Bu mesajı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.') }}
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showConfirmDeleteMessageModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-danger-button wire:click="deleteMessage" wire:loading.attr="disabled">
                {{ __('Sil') }}
            </x-danger-button>
        </div>
    </x-slot>
</x-confirmation-modal>

<!-- User Ban Confirmations -->
<x-confirmation-modal wire:model.defer="showBanConfirmModal">
    <x-slot name="title">
        <span class="text-orange-600">{{ __('Kullanıcıyı Yasakla') }}</span>
    </x-slot>

    <x-slot name="content">
        {{ __('Bu kullanıcıyı forumdan yasaklamak istediğinizden emin misiniz? Yasaklanan kullanıcı forum içeriklerini görüntüleyebilir ancak yeni başlık açamaz ve mesaj gönderemez.') }}
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showBanConfirmModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-button wire:click="banUser" wire:loading.attr="disabled" class="bg-orange-500 hover:bg-orange-600">
                {{ __('Yasakla') }}
            </x-button>
        </div>
    </x-slot>
</x-confirmation-modal>

<x-confirmation-modal wire:model.defer="showUnbanConfirmModal">
    <x-slot name="title">
        <span class="text-green-600">{{ __('Kullanıcı Yasağını Kaldır') }}</span>
    </x-slot>

    <x-slot name="content">
        {{ __('Bu kullanıcının yasağını kaldırmak istediğinizden emin misiniz? Yasağı kaldırılan kullanıcı tekrar başlık açabilir ve mesaj gönderebilir.') }}
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-secondary-button wire:click="$set('showUnbanConfirmModal', false)" wire:loading.attr="disabled">
                {{ __('İptal') }}
            </x-secondary-button>

            <x-button wire:click="unbanUser" wire:loading.attr="disabled" class="bg-green-500 hover:bg-green-600">
                {{ __('Yasağı Kaldır') }}
            </x-button>
        </div>
    </x-slot>
</x-confirmation-modal> 