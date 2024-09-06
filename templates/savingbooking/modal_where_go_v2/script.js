// Get the modal
var modal = document.getElementById("hotelModal");

// Get the input
var input = document.getElementById("cityInput");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user hovers on the input, open the modal
input.onmouseover = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
