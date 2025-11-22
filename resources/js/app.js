// Modern interactions and animations for GoTix event ticketing system
import './components/event-booking.js';
import './components/dashboard-analytics.js';

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle functionality
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form validation feedback
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                    input.classList.remove('border-gray-300');
                } else {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-gray-300');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Please fill in all required fields', 'error');
            }
        });
    });

    // Star rating interaction
    const starRatings = document.querySelectorAll('.star-rating');
    starRatings.forEach(rating => {
        const stars = rating.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                // Set the rating value
                const ratingInput = rating.querySelector('input[type="hidden"]');
                if (ratingInput) {
                    ratingInput.value = index + 1;
                }

                // Update active stars
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('active', 'text-yellow-400');
                    } else {
                        s.classList.remove('active', 'text-yellow-400');
                    }
                });
            });
        });
    });

    // Modal functionality
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modals = document.querySelectorAll('.modal');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const targetModalId = this.getAttribute('data-modal-target');
            const targetModal = document.getElementById(targetModalId);

            if (targetModal) {
                targetModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        });
    });

    modals.forEach(modal => {
        const closeModal = modal.querySelector('.modal-close');

        if (closeModal) {
            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }

        // Close modal when clicking on backdrop
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });

    // Loading state for buttons
    const loadingButtons = document.querySelectorAll('[data-loading]');
    loadingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
            this.disabled = true;

            // Reset after 2 seconds (or based on form submission)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        });
    });

    // Image preview for file uploads
    const imageInputs = document.querySelectorAll('input[type="file"][data-preview]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.getAttribute('data-preview');
            const preview = document.getElementById(previewId);

            if (this.files && this.files[0] && preview) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Notification system
    window.showNotification = function(message, type = 'info') {
        const notificationContainer = document.querySelector('.notification-container') ||
                                    document.body.appendChild(document.createElement('div'));
        notificationContainer.classList.add('notification-container');

        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm ${
            type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
            type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
            type === 'warning' ? 'bg-yellow-100 border border-yellow-400 text-yellow-700' :
            'bg-blue-100 border border-blue-400 text-blue-700'
        }`;
        notification.innerHTML = `
            <div class="flex justify-between items-start">
                <span>${message}</span>
                <button class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        notificationContainer.appendChild(notification);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    };

    // Tab navigation
    const tabTriggers = document.querySelectorAll('[data-tab-target]');
    tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all triggers
            tabTriggers.forEach(t => t.classList.remove('active', 'text-blue-600', 'border-blue-500'));
            this.classList.add('active', 'text-blue-600', 'border-blue-500');

            // Hide all tab contents
            document.querySelectorAll('[data-tab-content]').forEach(content => {
                content.classList.add('hidden');
            });

            // Show target tab content
            const target = this.getAttribute('data-tab-target');
            const targetContent = document.querySelector(`[data-tab-content="${target}"]`);
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });

    // Initialize active tabs if needed
    const activeTab = document.querySelector('.tab-trigger.active');
    if (activeTab) {
        activeTab.click();
    }
});

// Utility functions
window.debounce = function(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

// Format currency
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
};