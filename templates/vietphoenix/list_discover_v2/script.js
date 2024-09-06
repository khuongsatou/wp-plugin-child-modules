const items = document.querySelectorAll('.carousel-item');
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');
let currentIndex = 0;
const totalItems = items.length;

function updateCarousel(index) {
    items.forEach((item, i) => {
        // Di chuyển mỗi mục theo chỉ số index và tạo hiệu ứng gần nhau
        const offset = (i - index) * 80; // Chỉnh khoảng cách giữa các mục
        item.style.transform = `translateX(${offset}%)`;
        
        // Xử lý trạng thái active và opacity
        item.classList.remove('active');
        if (i === index) {
            item.classList.add('active');
        }
    });
}

nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalItems; // Tăng index, lặp lại khi đạt đến cuối
    updateCarousel(currentIndex);
});

prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex === 0) ? totalItems - 1 : currentIndex - 1; // Giảm index
    updateCarousel(currentIndex);
});

// Khởi động carousel với mục đầu tiên
updateCarousel(currentIndex);
