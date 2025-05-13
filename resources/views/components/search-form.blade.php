<div class="w-full max-w-3xl">
    <form action="{{ route('doctor.search') }}" method="GET">
        {{-- Desktop View --}}
        <div class="hidden md:flex bg-white rounded-full overflow-hidden h-12 shadow-lg border border-gray-200">
            <div 
                x-data="combobox({ 
                    options: [
                        '{{ __("welcome.combobox_all") }}', 
                        '{{ __("welcome.combobox_specialty_1") }}', 
                        '{{ __("welcome.combobox_specialty_2") }}', 
                        '{{ __("welcome.combobox_specialty_3") }}', 
                        '{{ __("welcome.combobox_specialty_4") }}', 
                        '{{ __("welcome.combobox_specialty_5") }}', 
                        '{{ __("welcome.combobox_specialty_6") }}', 
                        '{{ __("welcome.combobox_specialty_7") }}', 
                        '{{ __("welcome.combobox_specialty_8") }}', 
                        '{{ __("welcome.combobox_specialty_9") }}'
                    ],
                    placeholder: '{{ __("welcome.search_placeholder_specialty") }}', 
                    name: 'query' 
                })" 
                class="relative flex-grow h-full"
            >
                <input type="hidden" :name="name" x-model="selectedValue">
                <input 
                    type="text" 
                    x-model="search" 
                    @focus="open = true" 
                    @click.away="open = false" 
                    @keydown.escape.prevent="open = false; clearSearch()" 
                    @keydown.enter.prevent="selectOption(filteredOptions[0] || search); open = false" 
                    placeholder="{{ __('welcome.search_placeholder_specialty') }}" 
                    class="w-full h-full pl-6 pr-10 text-base text-gray-700 placeholder-gray-500 border-0 focus:outline-none rounded-l-full bg-white" 
                    aria-label="{{ __('welcome.search_placeholder_specialty') }}"
                >
                <button type="button" @click="open = !open" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600" aria-label="{{ __('aria.toggle_options', ['Toggle options']) }}">
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div x-show="open" x-transition class="absolute z-30 mt-1 w-full bg-white rounded-md shadow-lg max-h-60 overflow-auto border border-gray-200" style="display: none;">
                    <template x-for="(option, index) in filteredOptions" :key="index">
                        <div @click="selectOption(option); open = false" class="cursor-pointer hover:bg-gray-100 px-4 py-2 text-gray-700" x-text="option"></div>
                    </template>
                    <div x-show="filteredOptions.length === 0 && search !== ''" class="px-4 py-2 text-gray-500 italic">{{ __('welcome.combobox_no_results') }}</div>
                </div>
            </div>
            <div 
                 x-data="combobox({ 
                     options: [
                         '{{ __("welcome.combobox_all") }}', 
                         '{{ __("welcome.combobox_city_1") }}',
                         '{{ __("welcome.combobox_city_2") }}',
                         '{{ __("welcome.combobox_city_3") }}',
                         '{{ __("welcome.combobox_city_4") }}',
                         '{{ __("welcome.combobox_city_5") }}',
                         '{{ __("welcome.combobox_city_6") }}',
                         '{{ __("welcome.combobox_city_7") }}',
                         '{{ __("welcome.combobox_city_8") }}',
                         '{{ __("welcome.combobox_city_9") }}',
                         '{{ __("welcome.combobox_city_10") }}',
                         '{{ __("welcome.combobox_city_11") }}',
                         '{{ __("welcome.combobox_city_12") }}'
                         // Add more cities using __() 
                     ],
                     placeholder: '{{ __("welcome.search_placeholder_city") }}', 
                     name: 'city' 
                 })" 
                class="relative h-full min-w-[180px] lg:min-w-[200px]"
            >
                <input type="hidden" :name="name" x-model="selectedValue">
                <input 
                    type="text" 
                    x-model="search" 
                    @focus="open = true" 
                    @click.away="open = false" 
                    @keydown.escape.prevent="open = false; clearSearch()" 
                    @keydown.enter.prevent="selectOption(filteredOptions[0] || search); open = false" 
                    placeholder="{{ __('welcome.search_placeholder_city') }}" 
                    class="w-full h-full pl-4 pr-10 text-base text-gray-700 placeholder-gray-500 border-0 focus:outline-none bg-white" 
                    aria-label="{{ __('welcome.search_placeholder_city') }}"
                >
                <button type="button" @click="open = !open" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600" aria-label="{{ __('aria.toggle_options', ['Toggle options']) }}">
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div x-show="open" x-transition class="absolute z-30 mt-1 w-full bg-white rounded-md shadow-lg max-h-60 overflow-auto border border-gray-200" style="display: none;">
                    <template x-for="(option, index) in filteredOptions" :key="index">
                        <div @click="selectOption(option); open = false" class="cursor-pointer hover:bg-gray-100 px-4 py-2 text-gray-700" x-text="option"></div>
                    </template>
                    <div x-show="filteredOptions.length === 0 && search !== ''" class="px-4 py-2 text-gray-500 italic">{{ __('welcome.combobox_no_results') }}</div>
                </div>
            </div>
            <button type="submit" class="bg-primary-500 text-white px-7 h-full rounded-r-full font-medium hover:bg-primary-600 transition duration-300 ease-in-out flex items-center justify-center shadow-lg" aria-label="{{ __('welcome.search') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                {{ __('welcome.search') }}
            </button>
        </div>

        {{-- Mobile View --}}
        <div class="md:hidden space-y-3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="query" placeholder="{{ __('welcome.search_placeholder_specialty') }}" class="w-full h-14 pl-12 pr-4 text-lg bg-white rounded-lg shadow-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500" aria-label="{{ __('welcome.mobile_search_label') }}">
            </div>
            <div class="relative">
                <select name="city" class="w-full h-14 appearance-none px-4 text-base bg-white rounded-lg shadow-sm border border-gray-300 pr-8 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500" aria-label="{{ __('welcome.mobile_city_select_label') }}">
                    <option value="">{{ __('welcome.all_cities') }}</option>
                    <option value="Adana">{{ __('welcome.combobox_city_1') }}</option>
                    <option value="Adıyaman">{{ __('welcome.combobox_city_2') }}</option>
                    {{-- Add other cities using __() --}}
                    <option value="İstanbul">{{ __('welcome.combobox_city_11') }}</option>
                    <option value="İzmir">{{ __('welcome.combobox_city_12') }}</option>
                </select>
                <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </span>
            </div>
            <button type="submit" class="w-full h-14 bg-primary-500 hover:bg-primary-600 text-white font-semibold text-lg rounded-lg shadow-sm flex items-center justify-center transition duration-150 ease-in-out" aria-label="{{ __('welcome.search') }}">
                {{ __('welcome.search') }}
            </button>
        </div>
    </form>
</div> 