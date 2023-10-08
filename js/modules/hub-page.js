
const hubPage = (isPremium) => {
    console.log('work');
    let masonry = new MinimasonryMin({
        container: '.generated-images-wrapper',
    });

    // JavaScript code to load images asynchronously

    const imgWrapper = document.querySelectorAll('.single-image');
    const reversedImgWrapper = Array.from(imgWrapper).reverse();
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
                    if(data.success !== false){
                        let APIimage = data.data[0].image;
                        image.src = APIimage;
                        spinner.classList.remove('show');
                        image.classList.remove('hide');
                    } else {
                        wrapper.remove();
                        wrapper.classList.add('hide');
                    }
                })
                .catch(error => {
                    wrapper.classList.add('hide');
                    }
                );


    })


}

export default hubPage;