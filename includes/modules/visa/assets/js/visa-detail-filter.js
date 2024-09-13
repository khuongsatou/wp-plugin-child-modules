document.addEventListener("DOMContentLoaded", function() {
    const infoItems = document.querySelectorAll(".info-item");
    
    infoItems.forEach((item, index) => {
        item.style.opacity = 0;
        setTimeout(() => {
            item.style.transition = "opacity 0.5s ease-in-out";
            item.style.opacity = 1;
        }, index * 200); // Delays each item's fade-in for a staggered effect
    });



   // Get all question elements
   const questions = document.querySelectorAll('.question');

   // Loop through each question and add click event listener
   questions.forEach((question) => {
       question.addEventListener('click', function() {
           const answer = this.nextElementSibling;

           // Toggle the 'hidden' class on the associated answer
           answer.classList.toggle('hidden');

           // Toggle the rotation of the icon
           this.classList.toggle('active');
       });
   });
});


