document.addEventListener('alpine:init', () => {
    window.Alpine.store('sidebar', {
        isOpen: true,
        collapsedGroups: [],
        
        // Methods
        close() {
            this.isOpen = false;
        },
        
        open() {
            this.isOpen = true;
        },
        
        toggleCollapsedGroup(group) {
            if (this.groupIsCollapsed(group)) {
                this.collapsedGroups = this.collapsedGroups.filter(
                    (collapsedGroup) => collapsedGroup !== group
                );
                
                return;
            }
            
            this.collapsedGroups = [...this.collapsedGroups, group];
        },
        
        groupIsCollapsed(group) {
            return this.collapsedGroups.includes(group);
        }
    });
}); 