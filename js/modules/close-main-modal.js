const closeMainModal = () => {

    const closeBtn = document.querySelector('.close-modal-button');
    const modal = document.querySelector('.main-modal-blur');
    const html = document.querySelector('html');

    closeBtn.addEventListener('click', (e) => {
        closeModal();
    })

    const closeModal = () => {
        localStorage.setItem('premium-modal','Off');
        html.classList.remove('modal-is-open');
        modal.classList.remove('open');

    }


    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('main-modal-blur')) {
            closeModal();
        }
    });

    window.addEventListener('keyup', function (e) {
        if (e.keyCode == 27) {
            closeModal();
        }
    })



}

export default closeMainModal;
