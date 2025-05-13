<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight" style="font-family: 'Orbitron', sans-serif;">
            {{ __('Forum Middleware Test') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    
                    <h2 class="mt-4 text-xl font-bold text-gray-800 dark:text-gray-200">
                        {{ $message }}
                    </h2>
                    
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        {{ __('Bu sayfayı görebildiğinize göre middleware ve yetkilendirme doğru çalışıyor.') }}
                    </p>
                    
                    <div class="mt-6">
                        <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-400 to-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                            {{ __('Forum Anasayfasına Dön') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 