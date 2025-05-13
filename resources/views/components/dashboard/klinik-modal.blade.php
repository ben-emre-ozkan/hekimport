<!-- Klinik Quick View Modal -->
<x-dashboard.modal id="klinik-quick-view" maxWidth="lg">
    <x-slot name="title">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Klinik Detayları</h3>
        </div>
    </x-slot>
    
    <div x-data="klinikQuickView()" x-init="init()" class="space-y-6">
        <!-- Clinic Info -->
        <div>
            <div class="flex items-center space-x-4 mb-4">
                <template x-if="clinicImage">
                    <img :src="clinicImage" class="h-20 w-20 rounded-lg object-cover border-2 border-blue-500" alt="Klinik Fotoğrafı">
                </template>
                <template x-if="!clinicImage">
                    <div class="h-20 w-20 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </template>
                <div>
                    <h4 class="text-xl font-semibold text-gray-900" x-text="clinicName"></h4>
                    <div class="text-gray-600 flex items-center">
                        <span x-text="address"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-indigo-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600" x-text="staff.length"></div>
                <div class="text-sm text-gray-600">Personel</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-purple-600" x-text="equipment.length"></div>
                <div class="text-sm text-gray-600">Ekipman</div>
            </div>
            <div class="bg-amber-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-amber-600" x-text="Object.keys(workingHours).length"></div>
                <div class="text-sm text-gray-600">Çalışma Günü</div>
            </div>
        </div>
        
        <!-- Working Hours -->
        <div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Çalışma Saatleri</h5>
            <div class="bg-gray-50 rounded-lg p-4">
                <template x-if="Object.keys(workingHours).length > 0">
                    <div class="grid grid-cols-1 gap-2">
                        <template x-for="(hours, day) in workingHours" :key="day">
                            <div class="flex justify-between items-center py-1 border-b border-gray-100 last:border-0">
                                <span class="font-medium text-gray-700" x-text="day"></span>
                                <span class="text-gray-600" x-text="hours"></span>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="Object.keys(workingHours).length === 0">
                    <p class="text-gray-400 italic">Çalışma saatleri eklenmemiş</p>
                </template>
            </div>
        </div>
        
        <!-- Staff List -->
        <div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Klinik Personeli</h5>
            <div class="bg-gray-50 rounded-lg p-4">
                <template x-if="staff.length > 0">
                    <div class="grid grid-cols-1 gap-2">
                        <template x-for="person in staff" :key="person.id">
                            <div class="flex items-center space-x-3 py-2 border-b border-gray-100 last:border-0">
                                <div class="flex-shrink-0">
                                    <template x-if="person.image">
                                        <img :src="person.image" class="h-8 w-8 rounded-full object-cover" alt="Personel">
                                    </template>
                                    <template x-if="!person.image">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                            <span x-text="person.name.charAt(0)"></span>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <span class="text-gray-800 font-medium" x-text="person.name"></span>
                                    <span class="text-gray-500 text-sm ml-2" x-text="person.role"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="staff.length === 0">
                    <p class="text-gray-400 italic">Personel eklenmemiş</p>
                </template>
            </div>
        </div>
    </div>
    
    <x-slot name="footer">
        <x-dashboard.button @click="window.closeModal('klinik-quick-view')" variant="secondary">
            Kapat
        </x-dashboard.button>
        <x-dashboard.button @click="window.location.href = '{{ url('/masam/klinik') }}'">
            Kliniğimi Yönet
        </x-dashboard.button>
    </x-slot>
</x-dashboard.modal>

<script>
    function klinikQuickView() {
        return {
            clinicName: '',
            clinicImage: null,
            address: '',
            workingHours: {},
            staff: [],
            equipment: [],
            
            init() {
                // In a real application, this would fetch data from the server
                // For now, we'll use mocked data
                this.fetchData();
            },
            
            fetchData() {
                // Simulate API call with setTimeout
                setTimeout(() => {
                    // Mock data
                    this.clinicName = '{{ auth()->user()->name }} Diş Kliniği';
                    this.clinicImage = null;
                    this.address = 'İstanbul / Kadıköy';
                    this.workingHours = {
                        'Pazartesi': '09:00 - 18:00',
                        'Salı': '09:00 - 18:00',
                        'Çarşamba': '09:00 - 18:00',
                        'Perşembe': '09:00 - 18:00',
                        'Cuma': '09:00 - 18:00',
                        'Cumartesi': '10:00 - 14:00'
                    };
                    this.staff = [
                        { id: 1, name: 'Ayşe Kaya', role: 'Asistan', image: null },
                        { id: 2, name: 'Mehmet Demir', role: 'Teknisyen', image: null },
                        { id: 3, name: 'Zeynep Çelik', role: 'Sekreter', image: null }
                    ];
                    this.equipment = [
                        { id: 1, name: 'Diş Ünitesi', count: 2 },
                        { id: 2, name: 'Panoramik Röntgen', count: 1 },
                        { id: 3, name: 'Otoklav', count: 1 },
                        { id: 4, name: 'Led Işınlı Dolgu Cihazı', count: 2 }
                    ];
                }, 300);
            }
        }
    }
</script> 