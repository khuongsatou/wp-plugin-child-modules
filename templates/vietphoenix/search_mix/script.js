// Tab functionality
const tabs = document.querySelectorAll('.tab');
tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelector('.tab.active').classList.remove('active');
        this.classList.add('active');
    });
});
