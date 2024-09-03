function openTab(evt, tabName) {
    // Get all elements with class="tab-pane" and hide them
    var tabContent = document.getElementsByClassName("tab-pane");
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none"; 
    }

    // Get all elements with class="tab" and remove the class "active"
    var tabs = document.getElementsByClassName("tab");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].className = tabs[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('flightTab').style.display = 'block'; // Show the first tab content by default
});
