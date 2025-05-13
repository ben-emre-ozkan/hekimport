export default function combobox(config) {
    return {
        open: false,
        search: '',
        options: config.options || [],
        placeholder: config.placeholder || 'Seçiniz...',
        name: config.name || 'combobox',
        selectedValue: '', // Holds the actual value sent in the form
        
        get filteredOptions() {
            if (this.search === '') {
                return this.options;
            }
            // Basic filtering, case-insensitive
            return this.options.filter(
                option => option.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        clearSearch() {
            this.search = '';
        },
        
        selectOption(option) {
            if(option && option !== 'Tümü') { // Ensure option exists before setting
                 this.search = option; 
                 this.selectedValue = option; // Set hidden input value
            } else {
                this.search = ''; // Clear display text if 'Tümü' or null/undefined selected
                this.selectedValue = ''; // Set hidden input value to empty
            }
            
            this.open = false;
        },

        // Optional: Close dropdown when clicking away
        init() {
            this.$watch('open', value => {
                if (value) {
                    // Maybe focus input or handle opening effects
                }
            });
        }
    };
} 