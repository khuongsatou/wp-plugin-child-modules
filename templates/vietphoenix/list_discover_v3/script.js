const carouselItems = document.querySelector('.carousel-items');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
const dots = document.querySelectorAll('.dot');
let index = 0;

nextBtn.addEventListener('click', () => {
    index++;
    if (index > 2) index = 0;
    carouselItems.style.transform = `translateX(${-index * 100}%)`;
    updateDots();
});

prevBtn.addEventListener('click', () => {
    index--;
    if (index < 0) index = 2;
    carouselItems.style.transform = `translateX(${-index * 100}%)`;
    updateDots();
});

dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
        index = i;
        carouselItems.style.transform = `translateX(${-index * 100}%)`;
        updateDots();
    });
});

function updateDots() {
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');
}
