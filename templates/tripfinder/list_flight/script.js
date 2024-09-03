document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mouseover', () => {
        card.classList.add('hover');
    });
    card.addEventListener('mouseout', () => {
        card.classList.remove('hover');
    });
});
