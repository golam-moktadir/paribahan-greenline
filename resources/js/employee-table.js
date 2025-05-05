document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('employeesTableBody');
    const paginationContainer = document.getElementById('paginationContainer');
    const infoContainer = document.getElementById('tableInfo');
    let currentSort = { column: 'employee_id', direction: 'desc' };
    
    // Initialize with default values
    fetchEmployees();
    
    // Search input handler with debounce
    document.getElementById('searchInput').addEventListener('input', debounce(fetchEmployees, 300));
    
    // Per page select handler
    document.getElementById('perPageSelect').addEventListener('change', fetchEmployees);
    
    // Sort handler
    document.querySelectorAll('[data-sort]').forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.sort;
            currentSort.direction = currentSort.column === column && currentSort.direction === 'asc' ? 'desc' : 'asc';
            currentSort.column = column;
            fetchEmployees();
        });
    });
    
    // Pagination handler (delegated)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.page-link') && !e.target.closest('.disabled')) {
            e.preventDefault();
            fetchEmployees(e.target.closest('a').href.split('page=')[1]);
        }
    });
    
    function fetchEmployees(page = 1) {
        const params = new URLSearchParams({
            search: document.getElementById('searchInput').value,
            per_page: document.getElementById('perPageSelect').value,
            sort_by: currentSort.column,
            sort_direction: currentSort.direction,
            page: page,
            ajax: true
        });
        
        fetch(`/employees?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = data.html;
            paginationContainer.innerHTML = data.pagination;
            infoContainer.textContent = data.info;
            updateSortIcons();
        });
    }
    
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    function updateSortIcons() {
        document.querySelectorAll('[data-sort]').forEach(header => {
            const icon = header.querySelector('.sort-icon');
            if (header.dataset.sort === currentSort.column) {
                icon.className = `sort-icon fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'}`;
            } else {
                icon.className = 'sort-icon fas fa-sort';
            }
        });
    }
});