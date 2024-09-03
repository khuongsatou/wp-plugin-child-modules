let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');
const dots = document.querySelectorAll('.dot');
const totalItems = items.length;

document.querySelector('.carousel-nav.left').addEventListener('click', () => {
    changeSlide(-1);
});

document.querySelector('.carousel-nav.right').addEventListener('click', () => {
    changeSlide(1);
});

dots.forEach(dot => {
    dot.addEventListener('click', (e) => {
        const index = parseInt(e.target.getAttribute('data-index'));
        changeSlide(index - currentIndex);
    });
});

function changeSlide(direction) {
    items[currentIndex].classList.remove('active');
    dots[currentIndex].classList.remove('active');
    currentIndex = (currentIndex + direction + totalItems) % totalItems;
    items[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active');
}
