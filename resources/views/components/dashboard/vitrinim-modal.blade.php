<!-- Vitrinim Profile Quick View Modal -->
<x-dashboard.modal id="vitrinim-quick-view" maxWidth="lg">
    <x-slot name="title">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-teal-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Vitrinim Detayları</h3>
        </div>
    </x-slot>
    
    <div x-data="vitrinimQuickView()" x-init="init()" class="space-y-6">
        <!-- Profile Info -->
        <div>
            <div class="flex items-center space-x-4 mb-4">
                <template x-if="profileImage">
                    <img :src="profileImage" class="h-20 w-20 rounded-full object-cover border-2 border-teal-500" alt="Profil Fotoğrafı">
                </template>
                <template x-if="!profileImage">
                    <div class="h-20 w-20 rounded-full bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center text-white text-2xl font-bold">
                        <span x-text="nameInitial"></span>
                    </div>
                </template>
                <div>
                    <h4 class="text-xl font-semibold text-gray-900" x-text="doctorName"></h4>
                    <div class="text-gray-600 flex items-center">
                        <template x-if="specialties.length > 0">
                            <span x-text="specialties.join(', ')"></span>
                        </template>
                        <template x-if="specialties.length === 0">
                            <span class="text-gray-400 italic">Uzmanlık alanları eklenmemiş</span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-600" x-text="stats.views"></div>
                <div class="text-sm text-gray-600">Görüntülenme</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600" x-text="stats.appointments"></div>
                <div class="text-sm text-gray-600">Randevu</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-purple-600" x-text="stats.services"></div>
                <div class="text-sm text-gray-600">Hizmet</div>
            </div>
        </div>
        
        <!-- Bio Section -->
        <div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Biyografi</h5>
            <div class="bg-gray-50 rounded-lg p-4">
                <template x-if="bio">
                    <p class="text-gray-600" x-text="bio"></p>
                </template>
                <template x-if="!bio">
                    <p class="text-gray-400 italic">Biyografi eklenmemiş</p>
                </template>
            </div>
        </div>
        
        <!-- Services -->
        <div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Hizmetler</h5>
            <div class="bg-gray-50 rounded-lg p-4">
                <template x-if="services.length > 0">
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="service in services" :key="service.id">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 rounded-full bg-teal-500"></div>
                                <span class="text-gray-600" x-text="service.name"></span>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="services.length === 0">
                    <p class="text-gray-400 italic">Hizmet eklenmemiş</p>
                </template>
            </div>
        </div>
        
        <!-- Completion Status -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <h5 class="text-sm font-medium text-gray-700">Profil Tamamlanma Durumu</h5>
                <span class="text-sm font-medium text-gray-900" x-text="completionPercentage + '%'"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-gradient-to-r from-teal-500 to-blue-500 h-2.5 rounded-full transition-all duration-700" :style="'width: ' + completionPercentage + '%'"></div>
            </div>
        </div>
    </div>
    
    <x-slot name="footer">
        <x-dashboard.button @click="window.closeModal('vitrinim-quick-view')" variant="secondary">
            Kapat
        </x-dashboard.button>
        <x-dashboard.button @click="window.location.href = '{{ route('vitrinim') }}'">
            Vitrinimi Düzenle
        </x-dashboard.button>
    </x-slot>
</x-dashboard.modal>

<script>
    function vitrinimQuickView() {
        return {
            doctorName: '',
            profileImage: null,
            nameInitial: '',
            specialties: [],
            stats: {
                views: 0,
                appointments: 0,
                services: 0
            },
            bio: '',
            services: [],
            completionPercentage: 0,
            
            init() {
                // In a real application, this would fetch data from the server
                // For now, we'll use mocked data
                this.fetchData();
            },
            
            fetchData() {
                // Simulate API call with setTimeout
                setTimeout(() => {
                    // Mock data
                    this.doctorName = '{{ auth()->user()->name }}';
                    this.nameInitial = this.doctorName.charAt(0);
                    this.profileImage = '{{ auth()->user()->getFirstMediaUrl('profile_photos') }}';
                    this.specialties = ['Ortodonti', 'Endodonti'];
                    this.stats = {
                        views: 247,
                        appointments: 18,
                        services: 5
                    };
                    this.bio = 'Ortodonti ve Endodonti alanlarında 10 yıllık tecrübesi bulunan Diş Hekimi.';
                    this.services = [
                        { id: 1, name: 'Diş Çekimi' },
                        { id: 2, name: 'Dolgu' },
                        { id: 3, name: 'Kanal Tedavisi' },
                        { id: 4, name: 'Diş Taşı Temizliği' },
                        { id: 5, name: 'Ortodontik Tedavi' }
                    ];
                    this.completionPercentage = 85;
                }, 300);
            }
        }
    }
</script> 