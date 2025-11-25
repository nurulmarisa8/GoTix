// Event detail page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Ticket quantity calculator
    const ticketInputs = document.querySelectorAll('.ticket-quantity');
    const totalAmount = document.querySelector('.total-amount');
    
    if (ticketInputs.length > 0 && totalAmount) {
        function calculateTotal() {
            let total = 0;
            ticketInputs.forEach(input => {
                const price = parseInt(input.getAttribute('data-price')) || 0;
                const quantity = parseInt(input.value) || 0;
                total += price * quantity;
            });
            
            totalAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        ticketInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
            input.addEventListener('change', calculateTotal);
        });

        // Initialize total
        calculateTotal();
    }

    // Favorite toggle functionality
    const favoriteButtons = document.querySelectorAll('[data-favorite-toggle]');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const event_id = this.getAttribute('data-event-id');
            const icon = this.querySelector('svg');
            
            // Toggle the favorite state (in a real app, this would be an API call)
            if (icon.classList.contains('text-red-500')) {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-500');
            } else {
                icon.classList.remove('text-gray-500');
                icon.classList.add('text-red-500');
            }
        });
    });

    // Mobile menu toggle functionality
    const mobileMenuButton = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Form submission with loading state
    const bookingForms = document.querySelectorAll('#event-booking form');
    bookingForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('[type="submit"], .btn-primary');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...</span>';
                submitButton.disabled = true;
                
                // Simulate form submission delay
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 3000);
            }
        });
    });
});

// Utility functions
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Notification system
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm ${
        type === 'success' ? 'bg-green-100 border border-green-200 text-green-800' : 
        type === 'error' ? 'bg-red-100 border border-red-200 text-red-800' : 
        type === 'warning' ? 'bg-yellow-100 border border-yellow-200 text-yellow-800' : 
        'bg-blue-100 border border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-start">
            <div class="flex-1">
                <p>${message}</p>
            </div>
            <button class="ml-4 text-gray-600 hover:text-gray-800" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});