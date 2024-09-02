// Animation when hovering the button
document.querySelector('button').addEventListener('mouseover', function() {
    this.style.transform = 'scale(1.1)';
});

document.querySelector('button').addEventListener('mouseout', function() {
    this.style.transform = 'scale(1)';
});
