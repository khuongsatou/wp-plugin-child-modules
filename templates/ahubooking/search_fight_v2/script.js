function openTab(evt, tabName) {
    // Hide all tab content
    var tabContent = document.getElementsByClassName("tab-pane");
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none"; 
    }

    // Remove "active" class from all tabs
    var tabs = document.getElementsByClassName("tab");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].className = tabs[i].className.replace(" active", "");
    }

    // Show the current tab and add "active" class
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Initialize the first tab as active on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('flightTab').style.display = 'block';
});
