const menuButtons = document.querySelectorAll('.menu-btn');
const tabContents = document.querySelectorAll('.tab-content');

menuButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        document.querySelector('.menu-btn.active').classList.remove('active');
        // Add active class to the clicked button
        button.classList.add('active');

        // Hide all tab contents
        tabContents.forEach(content => content.classList.remove('active'));

        // Show the corresponding tab content
        const targetTab = button.getAttribute('data-tab');
        document.getElementById(targetTab).classList.add('active');
    });
});
