let currentIndex = 0;
const cards = document.querySelector('.cards');
const dots = document.querySelectorAll('.dot');
const itemsPerPage = 4;

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
    const totalItems = document.querySelectorAll('.card').length;
    const movePercentage = 100 / itemsPerPage;
    const maxIndex = Math.ceil(totalItems / itemsPerPage) - 1;

    if (currentIndex > maxIndex) {
        currentIndex = 0;
    } else if (currentIndex < 0) {
        currentIndex = maxIndex;
    }

    cards.style.transform = `translateX(-${currentIndex * movePercentage}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentIndex].classList.add('active');
}
