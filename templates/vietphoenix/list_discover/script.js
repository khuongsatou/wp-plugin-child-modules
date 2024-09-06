let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    items.forEach((item, i) => {
        item.style.transform = `translateX(${(i - index) * 100}%)`;
        dots[i].classList.remove('active');
    });
    dots[index].classList.add('active');
}

document.querySelector('.fa-chevron-left').addEventListener('click', () => {
    currentIndex = (currentIndex === 0) ? items.length - 1 : currentIndex - 1;
    showSlide(currentIndex);
});

document.querySelector('.fa-chevron-right').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % items.length;
    showSlide(currentIndex);
});
