// Example for adding animations or interactive elements if needed
document.querySelectorAll('.hotel-card').forEach(card => {
  card.addEventListener('mouseover', () => {
      card.classList.add('active');
  });

  card.addEventListener('mouseout', () => {
      card.classList.remove('active');
  });
});
