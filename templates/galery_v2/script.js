/* script.js */

const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
const image = document.querySelector('.image');

let currentIndex = 0;
const images = ["./img-1.png", "./img-2.png", "./img-3.png"];

function showImage(index) {
  image.src = images[index];
  currentIndex = index;
}

prevBtn.addEventListener('click', () => {
  currentIndex--;
  if (currentIndex < 0) {
    currentIndex = images.length - 1;
  }
  showImage(currentIndex);
});

nextBtn.addEventListener('click', () => {
  currentIndex++;
  if (currentIndex >= images.length) {
    currentIndex = 0;
  }
  showImage(currentIndex);
});

showImage(currentIndex);