// const daysGrid1 = document.getElementById('daysGrid1');
// const daysGrid2 = document.getElementById('daysGrid2');
// const monthYearDisplay1 = document.getElementById('monthYear1');
// const monthYearDisplay2 = document.getElementById('monthYear2');

// let currentDate = new Date();
// let nextDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
// let selectedDays = new Set();
// let startDate = null;
// let endDate = null;

// function loadCalendar() {
//     renderCalendar(currentDate, daysGrid1, monthYearDisplay1);
//     renderCalendar(nextDate, daysGrid2, monthYearDisplay2);
// }

// function renderCalendar(date, daysGrid, monthYearDisplay) {
//     const month = date.getMonth();
//     const year = date.getFullYear();

//     const firstDayOfMonth = new Date(year, month, 1).getDay();
//     const daysInMonth = new Date(year, month + 1, 0).getDate();

//     monthYearDisplay.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

//     daysGrid.innerHTML = '';

//     // Add blank days for the previous month's padding
//     for (let i = 0; i < firstDayOfMonth; i++) {
//         const blankDay = document.createElement('div');
//         blankDay.classList.add('day');
//         daysGrid.appendChild(blankDay);
//     }

//     // Add days of the month
//     for (let day = 1; day <= daysInMonth; day++) {
//         const dayElement = document.createElement('div');
//         dayElement.classList.add('day');
//         dayElement.textContent = day;
//         dayElement.dataset.day = day; // Add a data attribute to store the day number
//         dayElement.addEventListener('click', () => handleDayClick(dayElement));
//         daysGrid.appendChild(dayElement);
//     }
// }

// function handleDayClick(dayElement) {
//     const day = parseInt(dayElement.dataset.day);

//     if (!startDate || (startDate && endDate)) {
//         // If no start date or both start and end dates are already selected, reset selection
//         clearSelection();
//         startDate = day;
//         endDate = null;
//         dayElement.classList.add('selected');
//     } else if (startDate && !endDate) {
//         // If a start date is selected and no end date yet
//         endDate = day;
//         selectRange(startDate, endDate);
//     }
// }

// function selectRange(start, end) {
//     // Ensure the start is always less than or equal to end
//     if (start > end) [start, end] = [end, start];

//     for (let i = start; i <= end; i++) {
//         const dayElement = document.querySelector(`.day[data-day="${i}"]`);
//         if (dayElement) {
//             dayElement.classList.add('selected');
//             selectedDays.add(i);
//         }
//     }
// }

// function prevMonth() {
//     currentDate.setMonth(currentDate.getMonth() - 1);
//     nextDate.setMonth(nextDate.getMonth() - 1);
//     clearSelection();
//     loadCalendar();
// }

// function nextMonth() {
//     currentDate.setMonth(currentDate.getMonth() + 1);
//     nextDate.setMonth(nextDate.getMonth() + 1);
//     clearSelection();
//     loadCalendar();
// }

// function clearSelection() {
//     selectedDays.clear();
//     document.querySelectorAll('.day').forEach(day => day.classList.remove('selected'));
//     startDate = null;
//     endDate = null;
// }

// function showSelectedDays() {
//     alert('Selected Days: ' + Array.from(selectedDays).join(', '));
// }

// window.onload = loadCalendar;


const daysGrid1 = document.getElementById('daysGrid1');
const daysGrid2 = document.getElementById('daysGrid2');
const monthYearDisplay1 = document.getElementById('monthYear1');
const monthYearDisplay2 = document.getElementById('monthYear2');

let currentDate = new Date();
let nextDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
let selectedDays = new Set();
let startDate = null;
let endDate = null;

function loadCalendar() {
    renderCalendar(currentDate, daysGrid1, monthYearDisplay1);
    renderCalendar(nextDate, daysGrid2, monthYearDisplay2);
}

function renderCalendar(date, daysGrid, monthYearDisplay) {
    const month = date.getMonth();
    const year = date.getFullYear();

    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    monthYearDisplay.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

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
        dayElement.dataset.day = day; 
        dayElement.dataset.month = month; // Store the month for cross-calendar selection
        dayElement.dataset.year = year;  // Store the year for cross-calendar selection
        dayElement.addEventListener('click', () => handleDayClick(dayElement));
        daysGrid.appendChild(dayElement);
    }
}

function handleDayClick(dayElement) {
    const day = parseInt(dayElement.dataset.day);
    const month = parseInt(dayElement.dataset.month);
    const year = parseInt(dayElement.dataset.year);
    const selectedDate = new Date(year, month, day);

    if (!startDate || (startDate && endDate)) {
        // If no start date or both start and end dates are already selected, reset selection
        clearSelection();
        startDate = selectedDate;
        endDate = null;
        dayElement.classList.add('selected');
    } else if (startDate && !endDate) {
        // If a start date is selected and no end date yet
        endDate = selectedDate;
        selectRange(startDate, endDate);
    }
}

function selectRange(start, end) {
    // Ensure the start is always less than or equal to end
    if (start > end) [start, end] = [end, start];

    const allDays = document.querySelectorAll('.day');
    allDays.forEach(dayElement => {
        const day = parseInt(dayElement.dataset.day);
        const month = parseInt(dayElement.dataset.month);
        const year = parseInt(dayElement.dataset.year);
        const currentDate = new Date(year, month, day);

        if (currentDate >= start && currentDate <= end) {
            dayElement.classList.add('selected');
            selectedDays.add(currentDate.toDateString());
        }
    });
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    nextDate.setMonth(nextDate.getMonth() - 1);
    clearSelection();
    loadCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    nextDate.setMonth(nextDate.getMonth() + 1);
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
