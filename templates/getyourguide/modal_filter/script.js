const daysGrid = document.getElementById('daysGrid');
const monthYearDisplay = document.getElementById('monthYear');

let currentDate = new Date();
let selectedDays = new Set();
let startDate = null;
let endDate = null;

function loadCalendar() {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();

    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    monthYearDisplay.textContent = currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

    daysGrid.innerHTML = '';

    // Add blank days for the previous month's padding
    for (let i = 0; i < firstDayOfMonth; i++) {
        const blankDay = document.createElement('div');
        blankDay.classList.add('day');
        daysGrid.appendChild(blankDay);
    }

    // Add days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('day');
        dayElement.textContent = day;
        dayElement.dataset.day = day; // Add a data attribute to store the day number
        dayElement.addEventListener('click', () => handleDayClick(dayElement));
        daysGrid.appendChild(dayElement);
    }
}

function handleDayClick(dayElement) {
    const day = parseInt(dayElement.dataset.day);

    if (!startDate || (startDate && endDate)) {
        // If no start date or both start and end dates are already selected, reset selection
        clearSelection();
        startDate = day;
        endDate = null;
        dayElement.classList.add('selected');
    } else if (startDate && !endDate) {
        // If a start date is selected and no end date yet
        endDate = day;
        selectRange(startDate, endDate);
    }
}

function selectRange(start, end) {
    // Ensure the start is always less than or equal to end
    if (start > end) [start, end] = [end, start];

    for (let i = start; i <= end; i++) {
        const dayElement = document.querySelector(`.day[data-day="${i}"]`);
        if (dayElement) {
            dayElement.classList.add('selected');
            selectedDays.add(i);
        }
    }
}

function toggleDaySelection(dayElement) {
    const day = parseInt(dayElement.textContent);
    if (selectedDays.has(day)) {
        selectedDays.delete(day);
        dayElement.classList.remove('selected');
    } else {
        selectedDays.add(day);
        dayElement.classList.add('selected');
    }
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    clearSelection();
    loadCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    clearSelection();
    loadCalendar();
}

function clearSelection() {
    selectedDays.clear();
    document.querySelectorAll('.day').forEach(day => day.classList.remove('selected'));
    startDate = null;
    endDate = null;
}

function showSelectedDays() {
    alert('Selected Days: ' + Array.from(selectedDays).join(', '));
}

window.onload = loadCalendar;
