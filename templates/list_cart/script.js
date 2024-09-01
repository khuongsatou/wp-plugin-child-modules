document.querySelectorAll('.select-btn').forEach(button => {
    button.addEventListener('click', function() {
        const roomName = this.getAttribute('data-room');
        const roomPrice = parseInt(this.getAttribute('data-price'));
        console.log("In File: script.js, Line: 5",roomPrice);
        addToBookingSummary(roomName, roomPrice);
    });
});

function addToBookingSummary(roomName, roomPrice) {
    const bookingList = document.querySelector('.booking-summary ul');
    const totalElement = document.querySelector('.total p span');

    // Tạo phần tử mới cho phòng
    const li = document.createElement('li');
    li.innerHTML = `${roomName} <span>${roomPrice.toLocaleString()} đ</span>`;

    // Thêm phòng vào danh sách
    bookingList.appendChild(li);

    // Tính toán tổng cộng
    const currentTotal = parseInt(totalElement.innerText.replace(/\D/g, ''));
    const newTotal = currentTotal + roomPrice;
    totalElement.innerText = newTotal.toLocaleString() + ' đ';
}
