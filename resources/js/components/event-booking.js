// Event booking component for GoTix

class EventBooking {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.updateTotal();
    }
    
    bindEvents() {
        // Quantity change events
        const quantityInputs = this.container.querySelectorAll('.ticket-quantity');
        quantityInputs.forEach(input => {
            input.addEventListener('change', () => this.updateTotal());
            input.addEventListener('input', () => this.validateQuantity(input));
        });
        
        // Form submission
        const bookingForm = this.container.querySelector('form');
        if (bookingForm) {
            bookingForm.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }
    
    validateQuantity(input) {
        const max = parseInt(input.max);
        const value = parseInt(input.value) || 0;
        
        if (value < 0) {
            input.value = 0;
        } else if (value > max) {
            input.value = max;
        }
    }
    
    updateTotal() {
        let total = 0;
        const quantityInputs = this.container.querySelectorAll('.ticket-quantity');
        
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            total += quantity * price;
        });
        
        const totalElement = this.container.querySelector('.total-amount');
        if (totalElement) {
            totalElement.textContent = this.formatCurrency(total);
        }
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Booking...
        `;
        submitButton.disabled = true;
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                window.showNotification('Booking successful!', 'success');
                form.reset();
                this.updateTotal();
            } else {
                window.showNotification(result.message || 'Booking failed. Please try again.', 'error');
            }
        } catch (error) {
            window.showNotification('An error occurred. Please try again.', 'error');
        } finally {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }
    
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }
}

// Initialize event booking when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const bookingContainer = document.getElementById('event-booking');
    if (bookingContainer) {
        new EventBooking('event-booking');
    }
});

// Favorite toggle functionality
class FavoriteToggle {
    constructor(button) {
        this.button = button;
        this.eventId = this.button.dataset.eventId;
        this.isFavorite = this.button.dataset.isFavorite === 'true';
        this.init();
    }
    
    init() {
        this.updateButton();
        this.button.addEventListener('click', (e) => this.toggle(e));
    }
    
    updateButton() {
        if (this.isFavorite) {
            this.button.innerHTML = `
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
            `;
        } else {
            this.button.innerHTML = `
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            `;
        }
    }
    
    async toggle(e) {
        e.preventDefault();
        
        const originalHTML = this.button.innerHTML;
        this.button.innerHTML = `
            <svg class="animate-spin w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
        this.button.disabled = true;
        
        try {
            const response = await fetch(`/events/${this.eventId}/favorite`, {
                method: this.isFavorite ? 'DELETE' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                this.isFavorite = !this.isFavorite;
                this.updateButton();
                const countElement = document.querySelector('.favorite-count');
                if (countElement) {
                    const currentCount = parseInt(countElement.textContent);
                    countElement.textContent = this.isFavorite ? currentCount + 1 : Math.max(0, currentCount - 1);
                }
            } else {
                throw new Error(result.message || 'Failed to update favorite status');
            }
        } catch (error) {
            window.showNotification(error.message, 'error');
            // Revert button state
            this.updateButton();
        } finally {
            this.button.disabled = false;
        }
    }
}

// Initialize favorites when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('[data-favorite-toggle]');
    favoriteButtons.forEach(button => new FavoriteToggle(button));
});