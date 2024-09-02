document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.step');
    const tabs = document.querySelectorAll('.tab-content');

    steps.forEach(step => {
        step.addEventListener('click', () => {
            const stepNumber = step.getAttribute('data-step');
            updateProgressBar(stepNumber);
            showTab(stepNumber);
        });
    });

    function updateProgressBar(step) {
        steps.forEach((item, index) => {
            if(index < step) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    function showTab(step) {
        tabs.forEach(tab => {
            if (tab.id === `tab-${step}`) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
    }
});
