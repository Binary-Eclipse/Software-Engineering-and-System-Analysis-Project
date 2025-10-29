document.addEventListener('DOMContentLoaded', function() {
    
    // --- Sidebar Toggle for Mobile ---
    const menuToggleOpen = document.getElementById('menu-toggle-open');
    const menuToggleClose = document.getElementById('menu-toggle-close');
    const sidebar = document.querySelector('.sidebar');

    if (menuToggleOpen && sidebar) {
        menuToggleOpen.addEventListener('click', () => {
            sidebar.classList.add('show');
        });
    }

    if (menuToggleClose && sidebar) {
        menuToggleClose.addEventListener('click', () => {
            sidebar.classList.remove('show');
        });
    }
    
    // Close sidebar if clicking outside of it on mobile
    document.addEventListener('click', (event) => {
        if (sidebar && sidebar.classList.contains('show') && !sidebar.contains(event.target) && event.target !== menuToggleOpen) {
            sidebar.classList.remove('show');
        }
    });


    // --- Chart.js Graph Initialization ---
    // Check if we are on the shop page by looking for the canvas elements
    const salesCtx = document.getElementById('salesChart');
    const profitCtx = document.getElementById('profitChart');
    
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Products Sold',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: '#4a69bd',
                    tension: 0.1
                }]
            }
        });
    }
    
    if (profitCtx) {
        new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Profit ($)',
                    data: [1200, 1900, 3000, 5000, 2300, 2900, 4100],
                    backgroundColor: '#1e3799',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // --- Editable Table Logic ---
    const tables = document.querySelectorAll('table.editable-table');
    tables.forEach(table => {
        table.addEventListener('click', function(e) {
            // Handle Edit/Save button click
            if (e.target.classList.contains('btn-edit') || e.target.classList.contains('btn-save')) {
                const button = e.target;
                const row = button.closest('tr');
                const isEditing = button.classList.contains('btn-edit');

                const cellsToEdit = row.querySelectorAll('td[data-field]');
                
                if (isEditing) {
                    // Switch to Edit Mode
                    cellsToEdit.forEach(cell => {
                        const fieldType = cell.getAttribute('data-type') || 'text';
                        const originalValue = cell.textContent;
                        cell.innerHTML = `<input type="${fieldType}" value="${originalValue}" />`;
                    });
                    button.textContent = 'Save';
                    button.classList.remove('btn-edit');
                    button.classList.add('btn-save');
                } else {
                    // Switch to View Mode (Save)
                    cellsToEdit.forEach(cell => {
                        const input = cell.querySelector('input');
                        cell.innerHTML = input.value;
                    });
                    button.textContent = 'Edit';
                    button.classList.remove('btn-save');
                    button.classList.add('btn-edit');
                    
                    // Here you would typically send an AJAX request to save data to the server
                    console.log('Data saved (simulated).');
                }
            }
            
            // Handle Delete button click
            if (e.target.classList.contains('btn-delete')) {
                const row = e.target.closest('tr');
                if (confirm('Are you sure you want to delete this row?')) {
                    row.remove();
                     // Here you would typically send an AJAX request to delete data from the server
                    console.log('Row deleted (simulated).');
                }
            }
        });
    });

});