import './bootstrap';

// Import components but not Alpine.js directly since Livewire includes it
import mobileMenu from './components/mobile-menu';
import combobox from './components/combobox';

// Properly integrate with Livewire's Alpine instance
document.addEventListener('livewire:init', () => {
    // Register components to Livewire's Alpine instance
    Livewire.on('alpine:init', () => {
        // Register Alpine data components
        Alpine.data('mobileMenu', mobileMenu);
        Alpine.data('combobox', combobox);
        
        // Add forum specific component for content loading
        Alpine.data('forumContent', () => ({
            isLoading: false,
            init() {
                // Listen for loading events from Livewire
                Livewire.on('loading', () => { this.isLoading = true });
                Livewire.on('loaded', () => { this.isLoading = false });
                Livewire.on('deferredContentLoaded', () => { console.log('Deferred content loaded'); });
            }
        }));
    });
});
