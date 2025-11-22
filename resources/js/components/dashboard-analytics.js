// Dashboard analytics and chart components for GoTix

class DashboardAnalytics {
    constructor() {
        this.charts = {};
        this.init();
    }
    
    init() {
        // Initialize when charts container exists
        if (document.getElementById('revenue-chart') || document.getElementById('booking-chart')) {
            this.loadCharts();
        }
        
        // Initialize data refresh
        this.setupAutoRefresh();
    }
    
    async loadCharts() {
        // Dynamically import Chart.js if not already loaded
        if (typeof Chart === 'undefined') {
            try {
                const ChartModule = await import('https://cdn.jsdelivr.net/npm/chart.js');
                window.Chart = ChartModule.default;
            } catch (error) {
                console.error('Failed to load Chart.js:', error);
                return;
            }
        }
        
        // Revenue chart
        const revenueCtx = document.getElementById('revenue-chart');
        if (revenueCtx) {
            this.createRevenueChart(revenueCtx);
        }
        
        // Booking chart
        const bookingCtx = document.getElementById('booking-chart');
        if (bookingCtx) {
            this.createBookingChart(bookingCtx);
        }
        
        // Event performance chart
        const performanceCtx = document.getElementById('performance-chart');
        if (performanceCtx) {
            this.createPerformanceChart(performanceCtx);
        }
    }
    
    createRevenueChart(ctx) {
        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue (IDR)',
                data: [12000000, 19000000, 15000000, 21000000, 18000000, 24000000, 22000000, 25000000, 23000000, 27000000, 30000000, 35000000],
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };
        
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Revenue'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        };
        
        this.charts.revenue = new Chart(ctx, config);
    }
    
    createBookingChart(ctx) {
        const data = {
            labels: ['Pending', 'Approved', 'Rejected'],
            datasets: [{
                label: 'Booking Status',
                data: [12, 85, 3],
                backgroundColor: [
                    'rgb(255, 193, 7)',
                    'rgb(40, 167, 69)',
                    'rgb(220, 53, 69)'
                ],
                hoverOffset: 4
            }]
        };
        
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Booking Status Distribution'
                    }
                }
            }
        };
        
        this.charts.booking = new Chart(ctx, config);
    }
    
    createPerformanceChart(ctx) {
        const data = {
            labels: ['Event A', 'Event B', 'Event C', 'Event D', 'Event E'],
            datasets: [{
                label: 'Ticket Sales',
                data: [65, 79, 90, 81, 56],
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        };
        
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Event Performance'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        
        this.charts.performance = new Chart(ctx, config);
    }
    
    setupAutoRefresh() {
        // Refresh data every 5 minutes
        setInterval(() => {
            this.refreshData();
        }, 5 * 60 * 1000);
    }
    
    async refreshData() {
        try {
            // In a real implementation, you would fetch updated data from your API
            // For now, we'll just update the chart with new random data
            if (this.charts.revenue) {
                // Update revenue chart with new data
                this.charts.revenue.data.datasets[0].data = this.charts.revenue.data.datasets[0].data.map(value => 
                    value + Math.floor(Math.random() * 1000000) - 500000
                );
                this.charts.revenue.update();
            }
        } catch (error) {
            console.error('Error refreshing chart data:', error);
        }
    }
}

// Initialize dashboard analytics when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on a dashboard page
    if (document.querySelector('.dashboard-container')) {
        new DashboardAnalytics();
    }
});

// Data table sorting and filtering
class DataTable {
    constructor(tableId) {
        this.table = document.getElementById(tableId);
        this.init();
    }
    
    init() {
        this.addSortListeners();
        this.addSearchListener();
        this.addPagination();
    }
    
    addSortListeners() {
        const headers = this.table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                this.sortTable(header);
            });
        });
    }
    
    sortTable(header) {
        const columnIndex = Array.from(header.parentElement.children).indexOf(header);
        const isAscending = header.getAttribute('data-sorted') !== 'asc';
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aText = a.children[columnIndex].textContent.trim();
            const bText = b.children[columnIndex].textContent.trim();
            
            // Try to parse as number for numeric sorting
            const aNum = parseFloat(aText.replace(/[^0-9.-]+/g, ""));
            const bNum = parseFloat(bText.replace(/[^0-9.-]+/g, ""));
            
            let comparison = 0;
            if (!isNaN(aNum) && !isNaN(bNum)) {
                comparison = aNum - bNum;
            } else {
                comparison = aText.localeCompare(bText);
            }
            
            return isAscending ? comparison : -comparison;
        });
        
        // Clear previous sort indicators
        this.table.querySelectorAll('th[data-sort]').forEach(th => {
            th.removeAttribute('data-sorted');
            th.innerHTML = th.innerHTML.replace(/ ▲| ▼/, '');
        });
        
        // Add sort indicator to current header
        header.setAttribute('data-sorted', isAscending ? 'asc' : 'desc');
        header.innerHTML = header.innerHTML + (isAscending ? ' ▲' : ' ▼');
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }
    
    addSearchListener() {
        const searchInput = document.getElementById(`${this.table.id}-search`);
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.filterTable(searchInput.value.toLowerCase());
            }, 300));
        }
    }
    
    filterTable(searchTerm) {
        const tbody = this.table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchTerm) ? '' : 'none';
        });
    }
    
    addPagination() {
        // Add pagination controls if needed
        const tbody = this.table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        const rowsPerPage = 10;
        let currentPage = 1;
        
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        
        // Create pagination controls
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'flex justify-center mt-4';
        
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.className = `mx-1 px-3 py-1 rounded ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200'}`;
            button.addEventListener('click', () => {
                this.showPage(i, rows, rowsPerPage);
                currentPage = i;
                
                // Update active button
                paginationContainer.querySelectorAll('button').forEach(btn => {
                    btn.className = `mx-1 px-3 py-1 rounded ${btn.textContent == i ? 'bg-blue-500 text-white' : 'bg-gray-200'}`;
                });
            });
            paginationContainer.appendChild(button);
        }
        
        if (this.table.parentNode) {
            this.table.parentNode.appendChild(paginationContainer);
        }
        
        // Show first page
        this.showPage(1, rows, rowsPerPage);
    }
    
    showPage(page, rows, rowsPerPage) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        
        rows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });
    }
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize data tables when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('table[data-sortable]');
    tables.forEach(table => {
        new DataTable(table.id);
    });
});