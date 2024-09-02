document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.sidebar ul li');
    const contentSections = document.querySelectorAll('.day-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and hide all content sections
            tabs.forEach(t => t.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));

            // Add active class to the clicked tab
            tab.classList.add('active');

            // Show the corresponding content section
            const day = tab.getAttribute('data-day');
            const contentToShow = document.querySelector(`.day-content[data-content="${day}"]`);
            contentToShow.classList.add('active');
        });
    });
});
