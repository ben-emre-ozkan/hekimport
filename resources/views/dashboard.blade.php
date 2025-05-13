<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Quick Actions -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Hızlı Erişim</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('vitrinim') }}" class="text-blue-600 hover:text-blue-800">
                                        Vitrinim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('klinik') }}" class="text-blue-600 hover:text-blue-800">
                                        Kliniğim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('masam') }}" class="text-blue-600 hover:text-blue-800">
                                        Masam
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Profile Summary -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Profil Özeti</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">İsim:</span> {{ Auth::user()->name }}</p>
                                <p><span class="font-medium">E-posta:</span> {{ Auth::user()->email }}</p>
                                <p><span class="font-medium">Kayıt Tarihi:</span> {{ Auth::user()->created_at->format('d.m.Y') }}</p>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Son Aktiviteler</h3>
                            <ul class="space-y-2">
                                <li class="text-sm text-gray-600">Henüz aktivite bulunmuyor.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
