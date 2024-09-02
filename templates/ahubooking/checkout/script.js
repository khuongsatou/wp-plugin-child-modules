document.querySelectorAll('.actions a').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        window.scroll({
            top: 0,
            behavior: 'smooth'
        });
    });
});
