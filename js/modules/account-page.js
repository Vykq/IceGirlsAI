
const accountPage = (isPremium) => {
    console.log('work');
    // let masonry = new MinimasonryMin({
    //     container: '.generated-images-wrapper',
    // });

    // JavaScript code to load images asynchronously

    const imageContainer = document.querySelector(".last-creations-wrapper");
    const imgWrapper = document.querySelectorAll('.single-image');
    const images = imageContainer.querySelectorAll('.hub-single-image');

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
            const spinner = wrapper.querySelector('.spinner');
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
        });


}

export default accountPage;