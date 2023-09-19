const showTabs = () => {
    const tabButtons = document.querySelectorAll('.form-tab-button');
    const tabContainers = document.querySelectorAll('.single-tab-container');

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
