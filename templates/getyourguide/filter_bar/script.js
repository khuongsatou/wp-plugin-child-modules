document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        // Prevent the click event from propagating to the document
        event.stopPropagation();
        
        const parentItem = button.parentElement;
        const dropdown = parentItem.querySelector('.dropdown-content');

        // Close other dropdowns
        document.querySelectorAll('.filter-item').forEach(item => {
            if(item !== parentItem) {
                item.classList.remove('active');
                item.querySelector('.dropdown-content').style.display = 'none';
            }
        });

        // Toggle current dropdown
        if(parentItem.classList.contains('active')) {
            parentItem.classList.remove('active');
            dropdown.style.display = 'none';
        } else {
            parentItem.classList.add('active');
            dropdown.style.display = 'block';
        }
    });
});

// Close dropdown when clicking outside of any filter item
document.addEventListener('click', function() {
    document.querySelectorAll('.filter-item').forEach(item => {
        item.classList.remove('active');
        item.querySelector('.dropdown-content').style.display = 'none';
    });
});
