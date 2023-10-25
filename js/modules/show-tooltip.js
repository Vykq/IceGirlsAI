const showTooltip = () => {

    const tooltip = document.querySelector('.tooltip-icon');
    const modal = document.querySelector('.tooltip-modal');

    tooltip.addEventListener('mouseenter', () => {
        modal.classList.add('show');
    });

    tooltip.addEventListener('mouseleave', () => {
        modal.classList.remove('show');
    });

    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('tooltip-modal')) {
            modal.classList.remove('show');
        }
    });

}

export default showTooltip;