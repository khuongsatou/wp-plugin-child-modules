document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.rating-input .stars i');
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            stars.forEach((s, i) => {
                s.classList.toggle('fas', i <= index);
                s.classList.toggle('far', i > index);
            });
        });
    });
});
