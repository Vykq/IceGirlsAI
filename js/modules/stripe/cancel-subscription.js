const cancelSubscription = () => {

    const cancelSubBtn = document.querySelectorAll('.insta-cancel');
    const form = document.querySelector('.cancel-reason');

    const spinner = document.querySelector('.spinner-area');
    const cancelSubmitBtn = document.querySelector('.submit-cancel-form');
    const step1 = document.querySelector('#cancel-step1');
    const step2 = document.querySelector('#cancel-step2');
    const step3 = document.querySelector('#cancel-step3');

    const textArea = step1.querySelector('textarea');
    const statusInfoBlock = document.querySelector('.error-msg');
    const reasonInput = document.querySelectorAll('input[name="reasonInput"]');
    let IsReasonSelected = false;

    const updateSubBtn = document.querySelector('.update-sub');


    function showError(){
        step2.classList.add('hidden');
        step1.classList.add('hidden');
        step3.classList.remove('hidden');
    }


    const message = {
        loading: themeUrl.loading,
        success: themeUrl.success,
        failure: themeUrl.failure
    };


    reasonInput.forEach(el => {
        el.addEventListener('click', (e) => {
            IsReasonSelected = true;
            statusInfoBlock.textContent = "";
            reasonInput.forEach(e => {
                e.parentElement.classList.remove('error');
            })
        })
    })


    function reasonValue() {
        if(!IsReasonSelected) {
            reasonInput.forEach(el =>{
                const field = el.parentElement;
                field.classList.add('error');
                statusInfoBlock.textContent = themeUrl.cancel_reason;
            })
            return false;
        } else {
            return true;
        }
    }

    const validateForm = () => {
        if(!reasonValue()){
            return false;
        }
        return true;
    }

    const postDataForm = async (url, data) => {
        statusInfoBlock.textContent = message.loading;
        let res = await fetch(url, {
            method: 'POST',
            body: data,
        });
        return await res.text();
    }



    form.addEventListener('submit', (e) => {
        e.preventDefault();
    })

    cancelSubmitBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (!validateForm()) {
            return false;
        } else {
            spinner.classList.remove('hidden');
        }

        let formData = new FormData(form);

        postDataForm(themeUrl.themeUrl + '/includes/cancel-reason.php', formData)
            .then((res) => {
                statusInfoBlock.textContent = message.success;
            })
            .catch(() => {
                statusInfoBlock.textContent = message.failure;
                spinner.classList.add('hidden');
            })
            .finally(() => {
                step2.classList.remove('hidden');
                step1.classList.add('hidden');
                spinner.classList.add('hidden');
            });
    })


    cancelSubBtn.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const subID = btn.value;
            const userID = btn.dataset.userid;
            e.preventDefault();
            spinner.classList.remove('hidden');
            console.log('clicked canced');
            const postData = async (url, data) => {
                let res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: data,
                });

                return await res.json(); // Parse the response as JSON
            }

            const data = new FormData();
            data.append('action', 'cancelSubscription');
            data.append('subID', subID);
            data.append('userID', userID);
            return postData(themeUrl.ajax_url, data)
                .then((res) => {
                    console.log(res);
                    spinner.classList.add('hidden');
                    if(res.success) {
                        location.reload();
                    } else {
                        const postData = async (url, data) => {
                            let res = await fetch(url, {
                                method: 'POST',
                                credentials: 'same-origin',
                                body: data,
                            });

                            return await res.json(); // Parse the response as JSON
                        }

                        const data = new FormData();
                        data.append('action', 'cancelSubscription2');
                        data.append('subID', subID);
                        data.append('userID', userID);
                        return postData(themeUrl.ajax_url, data)
                            .then((res) => {
                                console.log(res);
                                spinner.classList.add('hidden');
                                if(res.success) {
                                    location.reload();
                                } else {
                                    showError();
                                }


                            })
                            .catch((error) => {
                                console.log(error);
                                showError();
                                spinner.classList.add('hidden');
                            });



                    }


                })
                .catch((error) => {
                    console.log(error);
                    showError();
                    spinner.classList.add('hidden');
                });

        })
    })




        updateSubBtn.addEventListener('click', (e) => {
            const subItemID = updateSubBtn.value;
            const userID = updateSubBtn.dataset.userid;
            e.preventDefault();
            spinner.classList.remove('hidden');
            console.log('clicked update');
            const postData = async (url, data) => {
                let res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: data,
                });

                return await res.json(); // Parse the response as JSON
            }

            const data = new FormData();
            data.append('action', 'updateSubscription');
            data.append('subItemID', subItemID);
            data.append('userID', userID);
            return postData(themeUrl.ajax_url, data)
                .then((res) => {
                    console.log(res);
                    spinner.classList.add('hidden');
                    if(res.success) {
                        location.reload();
                    } else {
                        showError();
                    }


                })
                .catch((error) => {
                    console.log(error);
                    showError();
                    spinner.classList.add('hidden');
                });

        })

}

export default cancelSubscription;