/**
 * Vitrinim Analytics Tracking Script
 * This script handles analytics tracking for the Vitrinim profiles
 */

class VitrinimAnalytics {
    constructor(options = {}) {
        this.options = {
            vitrinId: null,
            trackingEndpoint: '/vitrin/analytics/track',
            debug: false,
            ...options
        };
        
        if (!this.options.vitrinId) {
            this.log('Vitrin ID is required for analytics tracking');
            return;
        }
        
        this.init();
    }
    
    init() {
        this.log('Initializing Vitrinim Analytics');
        
        // Track page view on load
        this.trackEvent('page_view');
        
        // Setup click tracking
        this.setupClickTracking();
        
        // Track time spent
        this.startTimeTracking();
    }
    
    /**
     * Track an event
     * @param {string} eventType - The type of event to track
     * @param {object} metadata - Additional data to track with the event
     */
    trackEvent(eventType, metadata = {}) {
        const data = {
            vitrin_id: this.options.vitrinId,
            event_type: eventType,
            source: this.getSource(),
            user_agent: navigator.userAgent,
            page: window.location.pathname,
            metadata: JSON.stringify({
                viewport: {
                    width: window.innerWidth,
                    height: window.innerHeight
                },
                referrer: document.referrer,
                ...metadata
            })
        };
        
        this.log('Tracking event', { eventType, data });
        
        // Send analytics data to the server
        fetch(this.options.trackingEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => this.log('Analytics event tracked', data))
        .catch(error => this.log('Error tracking analytics event', error));
    }
    
    /**
     * Setup click tracking for interactive elements
     */
    setupClickTracking() {
        // Track contact button clicks
        document.querySelectorAll('[data-track="contact"]').forEach(element => {
            element.addEventListener('click', () => {
                this.trackEvent('contact_click', {
                    element: element.getAttribute('data-track-info') || 'contact_button'
                });
            });
        });
        
        // Track service clicks
        document.querySelectorAll('[data-track="service"]').forEach(element => {
            element.addEventListener('click', () => {
                this.trackEvent('service_click', {
                    service: element.getAttribute('data-track-info') || 'unknown_service'
                });
            });
        });
        
        // Track gallery image views
        document.querySelectorAll('[data-track="gallery"]').forEach(element => {
            element.addEventListener('click', () => {
                this.trackEvent('gallery_view', {
                    image: element.getAttribute('data-track-info') || 'unknown_image'
                });
            });
        });
        
        // Track appointment button clicks
        document.querySelectorAll('[data-track="appointment"]').forEach(element => {
            element.addEventListener('click', () => {
                this.trackEvent('appointment_click', {
                    source: element.getAttribute('data-track-info') || 'appointment_button'
                });
            });
        });
    }
    
    /**
     * Start tracking time spent on page
     */
    startTimeTracking() {
        this.pageLoadTime = Date.now();
        
        // Track time spent on page when the user leaves
        window.addEventListener('beforeunload', () => {
            const timeSpentMs = Date.now() - this.pageLoadTime;
            const timeSpentSeconds = Math.round(timeSpentMs / 1000);
            
            this.trackEvent('time_spent', {
                seconds: timeSpentSeconds
            });
        });
        
        // Also track time at 30-second intervals
        this.timeInterval = setInterval(() => {
            const timeSpentMs = Date.now() - this.pageLoadTime;
            const timeSpentSeconds = Math.round(timeSpentMs / 1000);
            
            if (timeSpentSeconds % 30 === 0) {
                this.trackEvent('time_update', {
                    seconds: timeSpentSeconds
                });
            }
        }, 1000);
    }
    
    /**
     * Get the source of the visit
     * @returns {string} The source of the visit
     */
    getSource() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('utm_source')) {
            return params.get('utm_source');
        }
        
        if (document.referrer) {
            const referrer = new URL(document.referrer);
            return referrer.hostname;
        }
        
        return 'direct';
    }
    
    /**
     * Log a message to the console if debug is enabled
     * @param {string} message - The message to log
     * @param {object} data - Additional data to log
     */
    log(message, data = null) {
        if (this.options.debug) {
            console.log(`[VitrinimAnalytics] ${message}`, data || '');
        }
    }
}

// Make the analytics class available globally
window.VitrinimAnalytics = VitrinimAnalytics;

// Auto-initialize if the data attribute is present
document.addEventListener('DOMContentLoaded', () => {
    const vitrinElement = document.querySelector('[data-vitrin-id]');
    if (vitrinElement) {
        const vitrinId = vitrinElement.getAttribute('data-vitrin-id');
        const debug = vitrinElement.hasAttribute('data-debug');
        
        new VitrinimAnalytics({
            vitrinId,
            debug
        });
    }
}); 