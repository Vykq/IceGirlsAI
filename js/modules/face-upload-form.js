import checkFiles from "./check-files";
import checkName from "./check-name";
import isLoggedIn from "./api/is-logged-in";
import checkIfPremium from "./check-if-premium";
import addNewFaceToUI from "./add-new-face-to-ui";
const faceUploadForm = async () => {

    const form = document.querySelector('form.face-upload-form');
    const submitBtn = form.querySelector('button.face-upload-btn');
    const statusInfoBlock = form.querySelector('p.error-msg');
    const titleInput = form.querySelector('input[name="face-title"]');
    const fileWrapper = form.querySelector('.upload');
    const fileInput = form.querySelector('input[name="uploading-face"]');
    const inputMsg = form.querySelector('#input-msg');

    const loggedIn = await isLoggedIn();

    const message = {
        loading: themeUrl.loading_face,
        success: themeUrl.success_face,
        failure: themeUrl.failure
    };

    fileInput.onchange = function () {
        inputMsg.textContent = fileInput.value.replace(/.*[\/\\]/, '');
    };

    const clearInputs = () => {
        form.reset();
    };


    titleInput.addEventListener('change', () => {
        if (titleInput.classList.contains('error')) {
            titleInput.classList.remove('error');
            statusInfoBlock.textContent = '';
        }
    });


    fileInput.addEventListener('change',() => {
        if(fileWrapper.classList.contains('error')) {
            fileWrapper.classList.remove('error');
            statusInfoBlock.textContent = '';
        }
    });


    function nameValue() {
        if (checkName(titleInput, statusInfoBlock)) {
            return true;
        } else {
            return false;
        }
    }

    function fileValue() {
        if(checkFiles(fileInput, statusInfoBlock, fileWrapper)) {
            return true;
        } else {
            return false;
        }
    }


    const validateForm = () => {
        if (!nameValue()) {
            return false;
        }

        if (!fileValue()) {
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
        if(loggedIn){
            if(checkIfPremium()){
                if (!validateForm()) {
                    return false;
                }
            } else {
                document.querySelector('.premium-modal').classList.add('show');
                document.querySelector('html').classList.add('modal-is-open');
                return false;
            }
        } else {
            document.querySelector('.login-modal').classList.add('show');
            document.querySelector('html').classList.add('modal-is-open');
            return false;
        }

        let formData = new FormData(form);
        formData.append('action', 'uploadFaceImageToUser');
        return postData(themeUrl.ajax_url, formData)
            .then((res) => {
                console.log(res);
                const data = JSON.parse(res); // Parse the JSON response
                const postid = data.postid;
                console.log('fuf',postid);
                try {
                    addNewFaceToUI(postid);
                } catch (error) {
                    console.error(error);
                }
                statusInfoBlock.textContent = message.success;
            })
            .catch(() => {
                statusInfoBlock.textContent = message.failure;
            })
            .finally(() => {
                clearInputs();
                setTimeout(() => {
                    statusInfoBlock.textContent = '';
                }, 8000);
            });
    });



}

export default faceUploadForm;