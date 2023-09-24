
const showTabs = () => {
    const tabButtons = document.querySelectorAll('.form-tab-button');
    const tabContainers = document.querySelectorAll('.single-tab-container');
    const clearButtons = document.querySelectorAll('.clear-question');

    clearButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const clearName = button.dataset.clear;

            // Find all input elements with the same name as clearName
            const inputsToClear = document.querySelectorAll(`input[name="${clearName}"]`);

            // Loop through the found input elements and clear them
            inputsToClear.forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.checked = false; // Clear radio buttons and checkboxes
                } else if (input.type === 'text' || input.tagName === 'TEXTAREA') {
                    input.value = ''; // Clear text inputs and textareas
                }
            });
        });
    });


    // Add click event listeners to the tab buttons
    tabButtons.forEach(tabButton => {
        tabButton.addEventListener('click', (e) => {
            e.preventDefault();
            const dataId = tabButton.getAttribute('data-id');

            // Remove "active" class from all tab buttons
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Add "active" class to the clicked tab button
            tabButton.classList.add('active');

            // Hide all tab containers
            tabContainers.forEach(tabContainer => {
                tabContainer.classList.add('hidden');
            });

            // Show the corresponding tab container
            const matchingTabContainer = document.querySelector(`.${dataId}`);
            if (matchingTabContainer) {
                matchingTabContainer.classList.remove('hidden');
            }
        });
    });

    tabButtons.forEach(tab => {tab.classList.remove('active')});
    tabContainers.forEach(tab => {tab.classList.add('hidden')});
    // Show the first tab and corresponding content on page load
    tabButtons[0].classList.add('active');
    tabContainers[0].classList.remove('hidden');





}

export default showTabs;
