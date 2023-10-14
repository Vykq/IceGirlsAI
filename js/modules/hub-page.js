import MinimasonryMin from "minimasonry";
const hubPage = () => {

    const isPremium = false;
    let firstScroll = true; // Initialize firstScroll
    let limit = 12;
    let offset = 0;
    if (firstScroll) {
        firstScroll = false;
        offset = 1;
    } else {
        offset++;
    }


    let isLoadingMoreContent = false;

    let API_ENDPOINT = "agent-scheduler/v1/history?status=done&limit=12&offset=0";
    let apiUrl = themeUrl.apiUrl;



    fetch(apiUrl + API_ENDPOINT)
        .then(response => response.json())
        .then(data => {
            if(data.total) {
                const total = data.total;
                const tasks = data.tasks;
                createWrapper(total, tasks);
                let masonry = new MinimasonryMin({
                    container: '.generated-images-wrapper',
                });
            }
        })
        .catch(error => {
                console.log(error)
            }
        );

    function isScrolledToBottom() {
        return window.innerHeight + window.scrollY >= document.body.offsetHeight * 0.6;
    }


    const container = document.querySelector('.hub-page-template .container');
    const genImagesWrapper = document.createElement('div');
    genImagesWrapper.classList.add('generated-images-wrapper');
    container.append(genImagesWrapper);
    let masonry = new MinimasonryMin({
        container: '.generated-images-wrapper',
    });

    window.addEventListener("scroll", async () => {
        if (isScrolledToBottom()) {
            await loadMoreContent();
        }
    });

    async function loadMoreContent() {
        if (isLoadingMoreContent) {
            return; // Exit the function if it's already loading
        }
        isLoadingMoreContent = true;

        // Update the API endpoint with the new page/offset
        const newApiEndpoint = `agent-scheduler/v1/history?status=done&limit=${limit}&offset=${offset * limit}`;
        console.log(newApiEndpoint);

        try {
            const response = await fetch(apiUrl + newApiEndpoint);
            const data = await response.json();

            if (data.total) {
                const total = data.total;
                const tasks = data.tasks;
                createWrapper(total, tasks);

            }
        } catch (error) {
            console.log(error);
        } finally {
            offset++;
            isLoadingMoreContent = false; // Mark the content loading as complete
        }
    }

    async function fetchMoreContent(offset, limit) {

        // Update the API endpoint with the new page/offset
        let newApiEndpoint = `agent-scheduler/v1/history?status=done&limit=${limit}&offset=${offset * limit}`;
        console.log(newApiEndpoint)
        // Fetch the new content
        fetch(apiUrl + newApiEndpoint)
            .then((response) => response.json())
            .then((data) => {
                if (data.total) {
                    const total = data.total;
                    const tasks = data.tasks;
                    createWrapper(total, tasks);

                }
            })
            .catch((error) => {
                console.log(error);
            });
    }


    function createWrapper(total, tasks){

        tasks.forEach(task => {
            //console.log(task);
            const taskID = task.id;
            const width = task.params.width;
            const height = task.params.height;
            const size = `${width}x${height}`;
            //console.log(size);
            let imageClass = "normal";
            if(size == "512x512"){
                imageClass = "square";
            } else if (size == "960x512"){
                imageClass = 'horizontal';
            }

            const singleImage = document.createElement('div');
            singleImage.classList.add('single-image');
            singleImage.classList.add(imageClass);
            genImagesWrapper.append(singleImage);

            const imagePermalink = document.createElement('a');
            imagePermalink.href = "/generated-images/" + taskID;
            const loader = document.createElement('div');
            loader.classList.add('loaderis');
            const spinner = document.createElement('div');
            spinner.classList.add('spinner');
            spinner.classList.add('show');
            const load = document.createElement('span');
            load.classList.add('loader');
            spinner.append(load);
            loader.append(spinner);

            singleImage.append(imagePermalink);
            singleImage.append(loader);
            const singleWrapper = document.createElement('div');
            singleWrapper.classList.add('single-wrapper');
            imagePermalink.append(singleWrapper);

            const postImage = document.createElement('div');
            postImage.classList.add('post-image');
            singleWrapper.append(postImage);

            const image = document.createElement('img');
            image.classList.add('hub-single-image');
            image.classList.add('hide');
            image.classList.add(imageClass);
            image.dataset.id = taskID;
            image.classList.add('lazy');
            image.setAttribute('loading','lazy');
            image.alt = "IceGirls.AI generated image";
            postImage.append(image);
            let masonry = new MinimasonryMin({
                container: '.generated-images-wrapper',
            });
            fetchImage(taskID, image, spinner);
        });
    }


    function fetchImage(taskID, image, loader){
        return fetch(apiUrl + "agent-scheduler/v1/task/" + taskID + "/results?zip=false")
            .then(response => response.json())
            .then(data => {
                if(data.success !== false){
                    let APIimage = data.data[0].image;
                    image.src = APIimage;
                    loader.classList.remove('show');
                    image.classList.remove('hide');
                } else {
                    // wrapper.remove();
                    // wrapper.classList.add('hide');
                }
            })
            .catch(error => {
                    console.log(error);
                }
            );
    }

}


export default hubPage;