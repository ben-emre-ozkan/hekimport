<x-app-layout>
    @section('meta')
        <meta name="title" content="{{ $meta['title'] }}">
        <meta name="description" content="{{ $meta['description'] }}">
        <meta name="keywords" content="{{ $meta['keywords'] }}">
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-6">Doktor Ara</h1>
                    
                    <form action="{{ route('doctor.search') }}" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="specialty" class="block text-sm font-medium text-gray-700 mb-2">Uzmanlık</label>
                                <select id="specialty" name="query" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                    <option value="">Tüm Uzmanlıklar</option>
                                    <option value="Genel Diş Hekimliği">Genel Diş Hekimliği</option>
                                    <option value="Ortodonti">Ortodonti</option>
                                    <option value="Endodonti">Endodonti</option>
                                    <option value="Periodontoloji">Periodontoloji</option>
                                    <option value="Ağız, Diş ve Çene Cerrahisi">Ağız, Diş ve Çene Cerrahisi</option>
                                    <option value="Protetik Diş Tedavisi">Protetik Diş Tedavisi</option>
                                    <option value="Pedodonti">Pedodonti</option>
                                    <option value="İmplantoloji">İmplantoloji</option>
                                    <option value="Estetik Diş Hekimliği">Estetik Diş Hekimliği</option>
                                </select>
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Şehir</label>
                                <select id="city" name="city" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                    <option value="">Tüm Şehirler</option>
                                    <option value="İstanbul">İstanbul</option>
                                    <option value="Ankara">Ankara</option>
                                    <option value="İzmir">İzmir</option>
                                    <option value="Bursa">Bursa</option>
                                    <option value="Antalya">Antalya</option>
                                    <option value="Adana">Adana</option>
                                    <option value="Konya">Konya</option>
                                    <option value="Gaziantep">Gaziantep</option>
                                    <option value="Şanlıurfa">Şanlıurfa</option>
                                    <option value="Kocaeli">Kocaeli</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                                Doktor Bul
                            </button>
                        </div>
                    </form>

                    <!-- Search Results -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Arama Sonuçları</h2>
                        
                        @if(count($doctors ?? []) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($doctors as $doctor)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <div class="p-6">
                                        <div class="flex items-center justify-center mb-4">
                                            @if($doctor['profile_image'])
                                                <img src="{{ $doctor['profile_image'] }}" alt="{{ $doctor['name'] }}" class="w-24 h-24 rounded-full object-cover border-4 border-teal-100">
                                            @else
                                                <div class="w-24 h-24 rounded-full bg-teal-100 flex items-center justify-center border-4 border-teal-200">
                                                    <span class="text-4xl">👨‍⚕️</span>
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-semibold text-center mb-2">{{ $doctor['name'] }}</h3>
                                        <p class="text-gray-600 text-center mb-4">{{ $doctor['specialty'] }}</p>
                                        <p class="text-gray-500 text-center mb-4">{{ $doctor['city'] }}</p>
                                        <div class="flex justify-center">
                                            <a href="{{ $doctor['vitrin_url'] ?? '#' }}" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                                                Profili Görüntüle
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-4">Arama kriterlerinize uygun doktor bulunamadı.</p>
                                <p class="text-gray-600">Lütfen farklı bir arama kriteri deneyin veya filtrelerinizi temizleyin.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 