const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
const resultItems = document.querySelectorAll('.result-item');

// Show search results when clicking on the search bar
searchInput.addEventListener('focus', () => {
    searchResults.style.display = 'block';
});

// Hide search results when clicking outside the search bar
document.addEventListener('click', (event) => {
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
        searchResults.style.display = 'none';
    }
});

// Filter results based on the input
function filterResults() {
    const filter = searchInput.value.toLowerCase();
    let matchFound = false;

    resultItems.forEach(item => {
        const text = item.innerText.toLowerCase();
        if (text.includes(filter)) {
            item.style.display = 'flex';
            matchFound = true;
        } else {
            item.style.display = 'none';
        }
    });

    // Show or hide the results container based on matching items
    searchResults.style.display = matchFound ? 'block' : 'none';
}
