let currentSlide = 0;
const totalSlides = document.querySelectorAll('.carousel-item').length;
const slidesToShow = 4; // Number of items to show at once
const slideWidth = 100 / slidesToShow; // Percentage width of each item

function showSlide(index) {
  if (index > totalSlides - slidesToShow) currentSlide = 0;
  else if (index < 0) currentSlide = totalSlides - slidesToShow;
  else currentSlide = index;

  document.querySelector('.carousel-inner').style.transform = `translateX(-${currentSlide * slideWidth}%)`;
}

function nextSlide() {
  showSlide(currentSlide + 1);
}

function prevSlide() {
  showSlide(currentSlide - 1);
}
