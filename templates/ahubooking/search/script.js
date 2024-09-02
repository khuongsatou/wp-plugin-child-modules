const hoverInput = document.querySelector('.hover-input');
const modal = document.querySelector('.modal');
const closeIcon = document.querySelector('.close-icon');

hoverInput.addEventListener('mouseover', function() {
    modal.style.display = 'block';
});

hoverInput.addEventListener('mouseout', function(e) {
    if (!modal.contains(e.relatedTarget)) {
        modal.style.display = 'none';
    }
});

closeIcon.addEventListener('click', function() {
    modal.style.display = 'none';
});

modal.addEventListener('mouseleave', function() {
    modal.style.display = 'none';
});


document.querySelector('.confirm-btn').addEventListener('click', function() {
    // Lấy số lượng cabin từ select box
    const cabinCount = document.getElementById('cabin-select').value;

    // Lấy số lượng người lớn và trẻ em từ input
    const adultsCount = document.getElementById('adults').value;
    const childrenCount = document.getElementById('children').value;

    // Tạo chuỗi kết quả
    const resultString = `${cabinCount} cabin, ${adultsCount} người lớn, ${childrenCount} trẻ em`;

    // Đặt chuỗi vào input lớn
    document.querySelector('.hover-input').value = resultString;
});