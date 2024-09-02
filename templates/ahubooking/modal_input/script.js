const hoverInput = document.querySelector('.hover-input');
const modal = document.querySelector('.modal');
const closeIcon = document.querySelector('.close-icon');

hoverInput.addEventListener('mouseover', function() {
    modal.style.display = 'block';
});

hoverInput.addEventListener('mouseout', function(e) {
    if (!modal.contains(e.relatedTarget)) {
        modal.style.display = 'none';
    }
});

closeIcon.addEventListener('click', function() {
    modal.style.display = 'none';
});

modal.addEventListener('mouseleave', function() {
    modal.style.display = 'none';
});
