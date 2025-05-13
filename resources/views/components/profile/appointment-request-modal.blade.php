@props(['vitrin'])

<div
    x-data="appointmentRequestModal()"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
        ></div>

        <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

        <div 
            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-teal-500 to-blue-500 px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-orbitron text-lg font-medium text-white">
                        Randevu Talebi Oluştur
                    </h3>
                    <button 
                        type="button" 
                        class="rounded-md bg-transparent text-white hover:text-gray-200 focus:outline-none"
                        @click="open = false"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            <div 
                x-show="success" 
                class="bg-green-50 border border-green-200 p-4 rounded-md mx-4 my-4"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">
                            Randevu talebiniz başarıyla gönderildi! En kısa sürede sizinle iletişime geçilecektir.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Form -->
            <div x-show="!success" class="px-4 py-5 sm:p-6">
                <form @submit.prevent="submitRequest">
                    <div class="space-y-4">
                        <div>
                            <label for="patient_name" class="block text-sm font-medium text-gray-700">
                                Ad Soyad
                            </label>
                            <input
                                type="text"
                                id="patient_name"
                                x-model="form.patient_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                                placeholder="Ad ve soyadınızı giriniz"
                                required
                                minlength="2"
                            >
                            <p x-show="errors.patient_name" x-text="errors.patient_name" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <div>
                            <label for="patient_phone" class="block text-sm font-medium text-gray-700">
                                Telefon Numarası
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">
                                    +90
                                </span>
                                <input
                                    type="tel"
                                    id="patient_phone"
                                    x-model="form.patient_phone"
                                    class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                                    placeholder="5XXXXXXXXX"
                                    required
                                    pattern="5[0-9]{9}"
                                >
                            </div>
                            <p x-show="errors.patient_phone" x-text="errors.patient_phone" class="mt-1 text-sm text-red-600"></p>
                            <p class="mt-1 text-xs text-gray-500">Örnek: 5XXXXXXXXX (10 haneli)</p>
                        </div>

                        <div>
                            <label for="requested_slot" class="block text-sm font-medium text-gray-700">
                                Randevu Saati
                            </label>
                            <select
                                id="requested_slot"
                                x-model="form.requested_slot"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                                required
                            >
                                <option value="">Randevu saati seçiniz</option>
                                <template x-for="(slots, day) in availableSlots" :key="day">
                                    <optgroup :label="day">
                                        <template x-for="(slot, index) in slots" :key="index">
                                            <option :value="day + ' ' + slot" x-text="slot"></option>
                                        </template>
                                    </optgroup>
                                </template>
                            </select>
                            <p x-show="errors.requested_slot" x-text="errors.requested_slot" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Notlar (Opsiyonel)
                            </label>
                            <textarea
                                id="notes"
                                x-model="form.notes"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                                placeholder="Randevu ile ilgili eklemek istediğiniz notlar"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button
                            type="submit"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-gradient-to-r from-teal-500 to-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:from-teal-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm"
                            :disabled="loading"
                        >
                            <span x-show="loading" class="mr-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            <span x-show="!loading">Randevu Talebi Gönder</span>
                            <span x-show="loading">Gönderiliyor...</span>
                        </button>
                        <button
                            type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                            @click="open = false"
                            :disabled="loading"
                        >
                            İptal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function appointmentRequestModal() {
    return {
        open: false,
        loading: false,
        success: false,
        username: "{{ $vitrin->subdomain }}",
        availableSlots: @json($vitrin->working_hours ?? []),
        form: {
            patient_name: '',
            patient_phone: '',
            requested_slot: '',
            notes: ''
        },
        errors: {
            patient_name: '',
            patient_phone: '',
            requested_slot: ''
        },
        
        submitRequest() {
            this.loading = true;
            this.errors = {};
            
            // Format the phone number with +90 prefix
            const formattedPhone = '+90' + this.form.patient_phone;
            
            fetch(`/appointment/request/${this.username}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    patient_name: this.form.patient_name,
                    patient_phone: formattedPhone,
                    requested_slot: this.form.requested_slot,
                    notes: this.form.notes
                })
            })
            .then(response => response.json())
            .then(data => {
                this.loading = false;
                
                if (data.success) {
                    this.success = true;
                    this.form = {
                        patient_name: '',
                        patient_phone: '',
                        requested_slot: '',
                        notes: ''
                    };
                    
                    // Close the modal after 3 seconds
                    setTimeout(() => {
                        this.open = false;
                        this.success = false;
                    }, 3000);
                } else {
                    this.errors = data.errors || {};
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.loading = false;
                this.errors = {
                    general: 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.'
                };
            });
        }
    };
}
</script> 