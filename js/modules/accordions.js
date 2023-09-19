const accordion = () => {
    const buttons = document.querySelectorAll('.faq-title-block');
    const panels = document.querySelectorAll('.faq-answer-blocke');

    buttons.forEach(btn => {
        btn.addEventListener('click', (e) =>{
            e.preventDefault();
            const panel = btn.nextElementSibling;
            btn.classList.toggle('active');
            panel.classList.toggle('active');
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = 'calc(' + panel.scrollHeight + 'px + 1rem)';
            }
        })
    })

}
export default accordion;
