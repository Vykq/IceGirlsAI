
const singleImage = (isPremium) => {
    const imageContainer = document.querySelector(".image");
    const imgWrapper = document.querySelectorAll('.single-image');

    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow',
        keepalive: true
    };

    let apiUrl = themeUrl.apiUrl;

    imgWrapper.forEach(wrapper => {
        const spinner = wrapper.querySelector('.spinner')
        const image = wrapper.querySelector('.hub-single-image');

        spinner.classList.add('show');
        fetch(apiUrl + "agent-scheduler/v1/task/" + image.dataset.id + "/results?zip=false", requestOptions)
            .then(response => response.json())
            .then(data => {
                if(data.success !== false){
                    console.log('false');
                    let APIimage = data.data[0].image;
                    image.src = APIimage;
                    spinner.classList.remove('show');
                    image.classList.remove('hide');
                    image.classList.add('show');
                } else {
                    apiUrl = themeUrl.apiUrlFree;

                    // You can add more error handling logic here if needed


                    fetch(apiUrl + "agent-scheduler/v1/task/" + image.dataset.id + "/results?zip=false", requestOptions)
                        .then(response => response.json())
                        .then(data => {
                            if(data.success !== false){
                                let APIimage = data.data[0].image;
                                image.src = APIimage;
                                spinner.classList.remove('show');
                                image.classList.remove('hide');
                                image.classList.add('show');
                            } else {
                                wrapper.classList.add('hide');
                            }
                        })
                        .catch(retryError => {
                            console.error(retryError);
                            // Handle the retry error if needed
                        });
                }
            })
            .catch(error => {
                console.error(error); // Log the error for debugging purposes

                // Handle the error here and switch to the alternative API URL

            });


    })


}

export default singleImage;