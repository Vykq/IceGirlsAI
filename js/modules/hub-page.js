
const hubPage = (isPremium) => {
    console.log('work');
    // let masonry = new MinimasonryMin({
    //     container: '.generated-images-wrapper',
    // });

    // JavaScript code to load images asynchronously

    const imageContainer = document.querySelector(".generated-images-wrapper");
    const imgWrapper = document.querySelectorAll('.single-image');
    const reversedImgWrapper = Array.from(imgWrapper).reverse();
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


    reversedImgWrapper.forEach(wrapper => {
        const spinner = wrapper.querySelector('.spinner')
        const image = wrapper.querySelector('.hub-single-image');
        spinner.classList.add('show');

            return fetch(apiUrl + "agent-scheduler/v1/task/" + image.dataset.id + "/results?zip=false", requestOptions)
                .then(response => response.json())
                .then(data => {
                    let APIimage = data.data[0].image;
                    image.src = APIimage;
                    spinner.classList.remove('show');
                    image.classList.remove('hide');
                })
                .catch(error => {
                        return error;
                    }
                );


    })


}

export default hubPage;