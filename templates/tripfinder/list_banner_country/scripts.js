let currentIndex = 0;
const cards = document.querySelector('.cards');
const dots = document.querySelectorAll('.dot');

document.querySelector('.prev').addEventListener('click', () => {
    currentIndex = (currentIndex === 0) ? dots.length - 1 : currentIndex - 1;
    updateSlider();
});

document.querySelector('.next').addEventListener('click', () => {
    currentIndex = (currentIndex === dots.length - 1) ? 0 : currentIndex + 1;
    updateSlider();
});

dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentIndex = index;
        updateSlider();
    });
});

function updateSlider() {
    cards.style.transform = `translateX(-${currentIndex * 100}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentIndex].classList.add('active');
}
