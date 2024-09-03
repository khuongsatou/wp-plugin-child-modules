// script.js

// Ví dụ: Tạo slider cho các card
document.addEventListener('DOMContentLoaded', function () {
    const cardSlider = document.querySelector('.card-slider');
    let isDown = false;
    let startX;
    let scrollLeft;

    cardSlider.addEventListener('mousedown', (e) => {
        isDown = true;
        cardSlider.classList.add('active');
        startX = e.pageX - cardSlider.offsetLeft;
        scrollLeft = cardSlider.scrollLeft;
    });

    cardSlider.addEventListener('mouseleave', () => {
        isDown = false;
        cardSlider.classList.remove('active');
    });

    cardSlider.addEventListener('mouseup', () => {
        isDown = false;
        cardSlider.classList.remove('active');
    });

    cardSlider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - cardSlider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        cardSlider.scrollLeft = scrollLeft - walk;
    });
});
