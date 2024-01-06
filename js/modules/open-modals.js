import loadFaceImages from "./load-face-images";
import deleteFace from "./delete-face";

const openModals = () => {

    const modals = document.querySelectorAll('.modals');
    const openBtns = document.querySelectorAll('.open-modal');
    const closeBtns = document.querySelectorAll('.close-modal');
    const html = document.querySelector('html');
    const saveNotify = document.querySelector('.saved-notify');
    const promptInput2 = document.querySelector('#positive-prompt-2');
    const mobileMenu = document.querySelector('.mobile-menu');

    const checkpointsInput = document.querySelectorAll('input[name="checkpoint"]');
    const modelTitle = document.querySelector('#current-model');
    const actionsInput = document.querySelectorAll('input[name="action"]');
    const actionTitle = document.querySelector('#current-scene');
    const charsInput = document.querySelectorAll('input[name="char"]');
    const charTitle = document.querySelector('#current-char');
    const facesInput = document.querySelectorAll('input[name="face"]');
    const faceTitle = document.querySelector('#current-face');
    let openedModalClass = "";


    openBtns.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            mobileMenu.classList.remove('show');
            openedModalClass = btn.dataset.id;
            if(openedModalClass === "user-faces"){
                await loadFaceImages()
                await deleteFace();
            }
            modals.forEach(modal => {
                if(modal.classList.contains(btn.dataset.id)){
                    modal.classList.add('show');
                    html.classList.add('modal-is-open');
                }
            })
        })
    })

    window.addEventListener('keyup', function (e) {
        if (e.keyCode == 27) {
            closeModal();
        }
    })

    function closeModal() {
        modals.forEach(modal => {
            modal.classList.remove('show');
            html.classList.remove('modal-is-open');

            setTimeout(function() {
                saveNotify.classList.remove('show');
            }, 1000);
        })
    }

    closeBtns.forEach(btn => {
        btn.addEventListener('click', closeModal);
    })


    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('modals')) {
            closeModal();
        }
    });



    checkpointsInput.forEach(input =>{
        input.addEventListener('change', (e) => {
            modelTitle.textContent = input.nextElementSibling.textContent;
            saveNotify.classList.add('show');
            openBtns.forEach(btn => {
                if (btn.dataset.id === openedModalClass) {
                    const modalText = 'Style: ' + input.nextElementSibling.textContent;

                    if (modalText.length <= 26) {
                        btn.textContent = modalText;
                    } else {
                        // If the text exceeds 26 characters, truncate it and add "..."
                        btn.textContent = modalText.substring(0, 11) + '...';
                    }
                }
            })
            closeModal();
        })
    })

    actionsInput.forEach(input =>{
        input.addEventListener('change', (e) => {
            actionTitle.textContent = input.nextElementSibling.textContent;
            saveNotify.classList.add('show');
            openBtns.forEach(btn => {
                if (btn.dataset.id === openedModalClass) {
                    const modalText = 'Action: ' + input.nextElementSibling.textContent;

                    if (modalText.length <= 26) {
                        btn.textContent = modalText;
                    } else {
                        // If the text exceeds 26 characters, truncate it and add "..."
                        btn.textContent = modalText.substring(0, 11) + '...';
                    }
                }
            })
            closeModal();
        })
    })


    charsInput.forEach(input =>{
        input.addEventListener('change', (e) => {
            charTitle.textContent = input.nextElementSibling.textContent;
            saveNotify.classList.add('show');
            openBtns.forEach(btn => {
                if (btn.dataset.id === openedModalClass) {
                    const modalText = 'Char: ' + input.nextElementSibling.textContent;
                    if (modalText.length <= 26) {
                        if(input.nextElementSibling.textContent === "None"){
                            btn.textContent = 'Characters';
                        } else {
                            btn.textContent = modalText;
                        }
                    } else {
                        // If the text exceeds 26 characters, truncate it and add "..."
                        btn.textContent = modalText.substring(0, 11) + '...';
                    }
                }
            })
            closeModal();
        })
    })


    facesInput.forEach(input =>{
        input.addEventListener('change', (e) => {
            faceTitle.textContent = input.nextElementSibling.textContent;
            saveNotify.classList.add('show');
            openBtns.forEach(btn => {
                if (btn.dataset.id === openedModalClass) {
                    const modalText = 'Face: ' + input.nextElementSibling.textContent;
                    if (modalText.length <= 26) {
                        if(input.nextElementSibling.textContent === "None"){
                            btn.textContent = 'Saved faces';
                        } else {
                            btn.textContent = modalText;
                        }
                    } else {
                        // If the text exceeds 26 characters, truncate it and add "..."
                        btn.textContent = modalText.substring(0, 11) + '...';
                    }
                }
            })
            closeModal();
        })
    })

}

export default openModals;