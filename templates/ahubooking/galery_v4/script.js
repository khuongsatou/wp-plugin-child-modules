// scripts.js
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;
const carouselContent = document.querySelector('.carousel-content');

// Function to update the slide position
function updateCarousel() {
  const offset = -(100 * currentIndex); // Calculate the transform offset
  carouselContent.style.transform = `translateX(${offset}%)`;
}

// Function to show the next slide
function nextSlide() {
  currentIndex = (currentIndex + 1) % totalSlides; // Cycle to the next slide
  updateCarousel();
}

// Function to show the previous slide
function prevSlide() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Cycle to the previous slide
  updateCarousel();
}

// Event listeners for the navigation buttons
document.querySelector('.right-btn').addEventListener('click', nextSlide);
document.querySelector('.left-btn').addEventListener('click', prevSlide);

// Auto-slide every 3 seconds
setInterval(nextSlide, 3000);
