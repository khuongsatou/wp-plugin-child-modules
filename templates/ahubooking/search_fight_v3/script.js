// Function to handle main tab switching
function openMainTab(evt, tabName) {
    // Hide all main tab content
    var tabContent = document.getElementsByClassName("tab-pane");
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none"; 
        tabContent[i].classList.remove('active');
    }

    // Remove "active" class from all main tabs
    var tabs = document.getElementsByClassName("tab");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active");
    }

    // Show the current main tab and add "active" class
    document.getElementById(tabName).style.display = "block";
    document.getElementById(tabName).classList.add('active');
    evt.currentTarget.classList.add("active");
}

// Function to handle sub-tab switching
function openSubTab(evt, subTabName) {
    // Hide all sub-tab content
    var subTabContent = document.getElementsByClassName("sub-tab-pane");
    for (var i = 0; i < subTabContent.length; i++) {
        subTabContent[i].style.display = "none";
        subTabContent[i].classList.remove('active');
    }

    // Remove "active" class from all sub-tabs
    var subTabs = document.getElementsByClassName("sub-tab");
    for (var i = 0; i < subTabs.length; i++) {
        subTabs[i].classList.remove("active");
    }

    // Show the current sub-tab and add "active" class
    document.getElementById(subTabName).style.display = "block";
    document.getElementById(subTabName).classList.add('active');
    evt.currentTarget.classList.add("active");
}

// Initialize the first tab as active on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('flightTab').style.display = 'block';
    document.getElementById('planeSubTab').style.display = 'block';
});
