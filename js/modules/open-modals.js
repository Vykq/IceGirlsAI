const openModals = () => {

    const modals = document.querySelectorAll('.modals');
    const openBtns = document.querySelectorAll('.open-modal');
    const closeBtns = document.querySelectorAll('.close-modal');
    const html = document.querySelector('html');
    const saveNotify = document.querySelector('.saved-notify');
    const promptPreviewEl = document.querySelector('.prompt-preview-area');
    const promptInput = document.querySelector('#positive-prompt');
    const promptInput2 = document.querySelector('#positive-prompt-2');


    const checkpointsInput = document.querySelectorAll('input[name="checkpoint"]');
    const modelTitle = document.querySelector('#current-model');
    const actionsInput = document.querySelectorAll('input[name="action"]');
    const actionTitle = document.querySelector('#current-scene');
    let openedModalClass = "";


    openBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openedModalClass = btn.dataset.id;
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

    if(document.querySelector('.promptInput2')){
        promptInput2.addEventListener('input', (e) =>{
            promptInput.value = promptInput2.value;
        })
        promptInput.addEventListener('input', (e) =>{
            promptInput2.value = promptInput.value;
        })
    }

    function closeModal() {
        modals.forEach(modal => {
            modal.classList.remove('show');
            html.classList.remove('modal-is-open');
            if(promptInput) {
                if (promptInput.value != "") {
                    promptPreviewEl.classList.add('show');
                    promptInput2.textContent = promptInput.value;
                    promptInput2.value = promptInput.value;
                } else {
                    promptPreviewEl.classList.remove('show');
                    promptInput2.textContent = "";
                    promptInput2.value = "";
                }
            }

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
                if(btn.dataset.id === openedModalClass){
                    btn.textContent = 'Model: ' + input.nextElementSibling.textContent;
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
                if(btn.dataset.id === openedModalClass){
                    btn.textContent = 'Action: ' + input.nextElementSibling.textContent;
                }
            })
            closeModal();
        })
    })

}

export default openModals;