<x-filament-widgets::widget class="filament-widget">
    <x-filament::card>
        <h2 class="text-lg font-semibold tracking-tight text-gray-950 dark:text-white">
            Son Vitrin Hareketleri
        </h2>

        @if($this->analytics->isNotEmpty())
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10 table-auto">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Metrik
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Değer
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tarih
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-white/10">
                        @foreach($this->analytics as $analytic)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    {{ match ($analytic->metric) {
                                        'visit' => 'Görüntülenme',
                                        'click' => 'Tıklama',
                                        'impression' => 'Gösterim',
                                        default => ucfirst($analytic->metric)
                                    } }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    {{ $analytic->value }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    {{ $analytic->date ? \Carbon\Carbon::parse($analytic->date)->translatedFormat('d M Y') : '-' }} <!-- Format date -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                Henüz analitik veri bulunmamaktadır.
            </p>
        @endif

    </x-filament::card>
</x-filament-widgets::widget> 