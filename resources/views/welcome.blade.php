<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Diş Hekimi Bul</h1>
                        <p class="mt-2 text-lg text-gray-600">Türkiye'nin en kapsamlı diş hekimi arama platformu</p>
                    </div>

                    @livewire('search-vitrins')

                    <div class="mt-8 text-center">
                        <a href="{{ route('register') }}" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Diş Hekimi misiniz? Hemen Kaydolun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
