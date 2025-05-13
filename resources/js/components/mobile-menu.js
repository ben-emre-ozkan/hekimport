export default function mobileMenu() {
    return {
        open: false,
        toggle() {
            this.open = !this.open;
        },
        closeOnClickAway(event) {
            // Check if the click is outside the toggle button and the menu itself
            if (!this.$refs.toggleButton.contains(event.target) && !this.$refs.menuContainer.contains(event.target)) {
                this.open = false;
            }
        }
    }
} 