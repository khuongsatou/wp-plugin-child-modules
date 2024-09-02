document.querySelector('.check-button').addEventListener('click', function() {
    alert('Kiểm tra thông tin tour!');
});

document.querySelector('.contact-button').addEventListener('click', function() {
    alert('Liên hệ để biết thêm thông tin!');
});

document.querySelector('.container').addEventListener('mouseover', function() {
    document.body.style.backgroundColor = '#e3e7ec';
});

document.querySelector('.container').addEventListener('mouseout', function() {
    document.body.style.backgroundColor = '#f0f3f7';
});
