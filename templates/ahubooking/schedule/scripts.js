function toggleSchedule(id) {
    const content = document.getElementById(id);
    const icon = content.previousElementSibling.querySelector('i');

    if (content.classList.contains('show')) {
        // Ẩn nội dung với animation
        content.classList.remove('show');
        setTimeout(() => {
            content.style.display = 'none';
        }, 300); // Thời gian chờ bằng với thời gian transition (0.3s)
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    } else {
        // Hiển thị nội dung với animation
        content.style.display = 'block';
        setTimeout(() => {
            content.classList.add('show');
        }, 10); // Thời gian chờ để chắc chắn `display: block` đã được áp dụng
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    }
}
