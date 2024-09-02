document.addEventListener("DOMContentLoaded", function() {
    // Lấy tất cả các thẻ h2
    const headings = document.querySelectorAll('.rule-section h2');
    
    // Lặp qua từng thẻ h2 và thêm sự kiện click
    headings.forEach(heading => {
        heading.addEventListener('click', function() {
            // Toggle (ẩn/hiện) phần nội dung tiếp theo sau thẻ h2
            const content = this.nextElementSibling;
            if (content.style.display === 'none' || !content.style.display) {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        });
    });
});
