document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');

        // Add active class to the clicked tab
        this.classList.add('active');

        // Show the corresponding tab content
        const tabContentId = this.getAttribute('data-tab');
        const tabContent = document.getElementById(tabContentId);
        tabContent.style.display = 'block';

        // Trigger the fadeInTab animation
        tabContent.classList.add('animated');
    });
});
