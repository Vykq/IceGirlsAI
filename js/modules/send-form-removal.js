import checkEmail from "./check-email";
import isEmpty from "./is-empty";
const sendRemovalForm = () => {

    const form = document.querySelector('form.content-removal');
    const submitBtn = form.querySelector('button.send-form');
    const statusInfoBlock = form.querySelector('p.error-msg');
    const emailInput = form.querySelector('input[name="email"]');
    const urlInput = form.querySelector('input[name="url"]');
    const msgInput = form.querySelector('textarea');

    const message = {
        loading: themeUrl.loading,
        success: themeUrl.success,
        failure: themeUrl.failure
    };


    const clearInputs = () => {
        form.reset();
    };

    emailInput.addEventListener('change', () => {
        if (emailInput.classList.contains('error')) {
            emailInput.classList.remove('error');
            statusInfoBlock.classList.remove('field-error');
            statusInfoBlock.classList.remove('show');
            emailInput.previousElementSibling.classList.remove('error');
            statusInfoBlock.textContent = '';
        }
    });

    urlInput.addEventListener('change', () => {
        if (urlInput.classList.contains('error')) {
            urlInput.classList.remove('error');
            statusInfoBlock.classList.remove('field-error');
            statusInfoBlock.classList.remove('show');
            urlInput.previousElementSibling.classList.remove('error');
            statusInfoBlock.textContent = '';
        }
    });

    msgInput.addEventListener('change', () => {
        if (msgInput.classList.contains('error')) {
            msgInput.classList.remove('error');
            statusInfoBlock.classList.remove('field-error');
            statusInfoBlock.classList.remove('show');
            msgInput.previousElementSibling.classList.remove('error');
            statusInfoBlock.textContent = '';
        }
    });


    function emailValue() {
        if (checkEmail(emailInput, statusInfoBlock)) {
            return true;
        } else {
            emailInput.previousElementSibling.classList.add('error');
            return false;
        }
    }

    function urlValue(){
        if(isEmpty(urlInput)){
            statusInfoBlock.textContent = themeUrl.url_empty;
            return false;
        } else {
            urlInput.previousElementSibling.classList.add('error');
            return true;
        }
    }

    function msgValue(){
        if(isEmpty(msgInput)){
            statusInfoBlock.textContent = themeUrl.info_empty;
            msgInput.previousElementSibling.classList.add('error');
            msgInput.classList.add('error');
            return false;
        } else {

            return true;
        }
    }


    const validateForm = () => {

        if (!emailValue()) {
            return false;
        }

        if (!urlValue()) {
            return false;
        }

        if (!msgValue()) {
            return false;
        }

        return true;
    }

    const postData = async (url, data) => {
        statusInfoBlock.textContent = message.loading;
        let res = await fetch(url, {
            method: 'POST',
            body: data,
        });
        return await res.text();
    }



    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!validateForm()) {
            return false;
        }
        let formData = new FormData(form);

        postData(themeUrl.themeUrl + '/includes/send-removal-form.php', formData)
            .then((res) => {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    'event': 'form_registration'
                });
                statusInfoBlock.textContent = message.success;
            })
            .catch(() => {
                statusInfoBlock.textContent = message.failure;
            })
            .finally(() => {
                clearInputs();
                setTimeout(() => {
                    statusInfoBlock.textContent = '';
                    modal.classList.remove('show');
                    html.classList.remove('modal-is-open');
                }, 1000);

            });
    });





}

export default sendRemovalForm;