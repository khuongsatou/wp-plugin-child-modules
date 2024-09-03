document.querySelectorAll('.counter').forEach(counter => {
    const minusButton = counter.querySelector('.minus');
    const plusButton = counter.querySelector('.plus');
    const countDisplay = counter.querySelector('.count');

    minusButton.addEventListener('click', () => {
        let count = parseInt(countDisplay.textContent);
        if (count > 0) {
            count--;
            countDisplay.textContent = count;
        }
    });

    plusButton.addEventListener('click', () => {
        let count = parseInt(countDisplay.textContent);
        count++;
        countDisplay.textContent = count;
    });
});
