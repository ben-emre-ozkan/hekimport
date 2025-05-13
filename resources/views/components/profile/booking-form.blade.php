@props(['services'])

<section class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Randevu Al</h2>
    <form wire:submit="storeAppointment" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Ad Soyad</label>
            <input type="text" 
                   wire:model="name" 
                   id="name" 
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   aria-label="Ad Soyad">
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefon</label>
            <input type="tel" 
                   wire:model="phone" 
                   id="phone" 
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   aria-label="Telefon">
        </div>
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Tarih</label>
            <input type="date" 
                   wire:model="date" 
                   id="date" 
                   required
                   min="{{ now()->format('Y-m-d') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   aria-label="Randevu Tarihi">
        </div>
        <div>
            <label for="service" class="block text-sm font-medium text-gray-700">Hizmet</label>
            <select wire:model="service" 
                    id="service" 
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    aria-label="Hizmet Seçimi">
                @foreach($services as $service)
                    <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                aria-label="Randevu Al">
            Randevu Al
        </button>
    </form>
</section> 