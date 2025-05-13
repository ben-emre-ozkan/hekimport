<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <form wire:submit.prevent="updateTopic" class="space-y-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-300">Başlık</label>
            <input wire:model.defer="title" type="text" id="title" class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="forumCategoryId" class="block text-sm font-medium text-gray-300">Kategori</label>
            <select wire:model.defer="forumCategoryId" id="forumCategoryId" class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Kategori Seçiniz</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('forumCategoryId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <button type="button" wire:click="$dispatch('closeModal')" class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-600 hover:bg-gray-500 rounded-md">İptal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 rounded-md">Kaydet</button>
        </div>
    </form>
</div>
