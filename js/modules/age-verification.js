const ageVerification = () => {

    const closeBtn = document.querySelector('.confirm-age');
    const modal = document.querySelector('.age-verification');
    const html = document.querySelector('html');
    const declineBtn = document.querySelector('.decline-age');

    closeBtn.addEventListener('click', (e) => {
        closeModal();
    })

    declineBtn.addEventListener('click', (e) =>{
        e.preventDefault();
        window.location = "https://www.google.com/";
    })

    const closeModal = () => {
        localStorage.setItem('age','18');
        html.classList.remove('modal-is-open');
        modal.classList.remove('show');

    }


    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('age-verification')) {
            closeModal();
        }
    });

    window.addEventListener('keyup', function (e) {
        if (e.keyCode == 27) {
            closeModal();
        }
    })



}

export default ageVerification;