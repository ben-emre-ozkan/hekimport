<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Özel Domain Yönetimi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900">Domain Ekle</h3>
                        <form action="{{ route('custom-domains.store') }}" method="POST" class="mt-4">
                            @csrf
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input type="text" 
                                           name="domain" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="ornek.com"
                                           required>
                                </div>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Domain Ekle
                                </button>
                            </div>
                        </form>
                    </div>

                    @if($customDomains->isNotEmpty())
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">DNS Kaydı</h3>
                            @if($dnsRecord)
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-sm text-gray-600">Aşağıdaki DNS kaydını domain sağlayıcınızda oluşturun:</p>
                                    <div class="mt-2 bg-white p-3 rounded border">
                                        <p class="font-mono text-sm">
                                            <span class="text-gray-600">Tür:</span> {{ $dnsRecord['type'] }}<br>
                                            <span class="text-gray-600">İsim:</span> {{ $dnsRecord['name'] }}<br>
                                            <span class="text-gray-600">Değer:</span> {{ $dnsRecord['value'] }}<br>
                                            <span class="text-gray-600">TTL:</span> {{ $dnsRecord['ttl'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Domainlerim</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doğrulama Tarihi</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($customDomains as $domain)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $domain->domain }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $domain->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ $domain->status === 'active' ? 'Aktif' : 'Doğrulanmadı' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $domain->verified_at ? $domain->verified_at->format('d.m.Y H:i') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if($domain->status !== 'active')
                                                        <a href="{{ route('custom-domains.verify', $domain) }}" 
                                                           class="text-blue-600 hover:text-blue-900 mr-4">Doğrula</a>
                                                    @endif
                                                    <form action="{{ route('custom-domains.destroy', $domain) }}" 
                                                          method="POST" 
                                                          class="inline-block"
                                                          onsubmit="return confirm('Bu domaini kaldırmak istediğinizden emin misiniz?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Kaldır</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Henüz özel domain eklenmemiş.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 