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


// Modal functions
const modal = document.getElementById("modal");
const span = document.getElementsByClassName("close")[0];
const modalImages = document.querySelectorAll('.modal-image');
const modalPrev = document.querySelector('.modal-prev');
const modalNext = document.querySelector('.modal-next');
let modalIndex = 0;

function openModal() {
  modal.style.display = "block";
}

function closeModal() {
  modal.style.display = "none";
}

span.onclick = function() {
  closeModal();
}

window.onclick = function(event) {
  if (event.target == modal) {
    closeModal();
  }
}

// Modal Carousel
function showModalImage(index) {
  for (let i = 0; i < modalImages.length; i++) {
    modalImages[i].style.display = "none";
  }
  modalImages[index].style.display = "block";
  modalIndex = index;
}

modalPrev.addEventListener('click', () => {
  modalIndex--;
  if (modalIndex < 0) {
    modalIndex = modalImages.length - 1;
  }
  showModalImage(modalIndex);
});

modalNext.addEventListener('click', () => {
  modalIndex++;
  if (modalIndex >= modalImages.length) {
    modalIndex = 0;
  }
  showModalImage(modalIndex);
});

showModalImage(modalIndex);

// Open Modal on image click
document.querySelector('.image-container').addEventListener('click', () => {
  openModal();
  showModalImage(0);
});