import MinimasonryMin from "minimasonry";
import watermark from "watermarkjs/lib";
import checkIfPremium from "./check-if-premium";
const hubPage = async () => {

    const isPremium = checkIfPremium();
    let firstScroll = true; // Initialize firstScroll
    let limit = 12;
    let offset = 0;

    const container = document.querySelector('.hub-page-template .container');
    const genImagesWrapper = document.createElement('div');
    genImagesWrapper.classList.add('generated-images-wrapper');
    container.append(genImagesWrapper);
    let masonry = new MinimasonryMin({
        container: '.generated-images-wrapper',
    });

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
        .then(async data => { // Add 'async' here
            if (data.total) {
                const total = data.total;
                const tasks = data.tasks;
                await createWrapper(total, tasks); // This should work now
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

    async function createWrapper(total, tasks) {
        tasks.forEach(task => {
                const taskID = task.id;
                const width = task.params.width;
                const height = task.params.height;
                const size = `${width}x${height}`;

                let imageClass = "normal";
                if (size == "512x512") {
                    imageClass = "square";
                } else if (size == "768x512") {
                    imageClass = 'horizontal';
                }

                const singleImage = document.createElement('div');
                singleImage.classList.add('single-image');
                singleImage.classList.add(imageClass);
                genImagesWrapper.append(singleImage);

                const imagePermalink = document.createElement('a');
                imagePermalink.href = "/generated-images/" + taskID;
                singleImage.append(imagePermalink);
                const loader = document.createElement('div');
                loader.classList.add('loaderis');
                const spinner = document.createElement('div');
                spinner.classList.add('spinner');
                spinner.classList.add('show');
                const load = document.createElement('span');
                load.classList.add('loader');
                spinner.append(load);
                loader.append(spinner);


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
                image.setAttribute('loading', 'lazy');
                image.alt = "IceGirls.AI generated image";
                let masonry = new MinimasonryMin({
                    container: '.generated-images-wrapper',
                });

                // Use await here to wait for fetchImage to complete before moving to the next iteration
                fetchImage(taskID, image, spinner, postImage, size);
            })

    }


    async function fetchImage(taskID, image, loader, postImage, size) {
        try {
            const response = await fetch(apiUrl + "agent-scheduler/v1/task/" + taskID + "/results?zip=false");
            const data = await response.json();

            if (data.success !== false) {
                let APIimage = data.data[0].image;
                if(!isPremium) {
                    const watermarkedImage = await watermark([APIimage, themeUrl.themeUrl + '/assets/images/watermark.jpg'])
                        .image((uploadImage, logo) => {
                            const context = uploadImage.getContext('2d');

                            // Get the width and height of the original image
                            const imageWidth = uploadImage.width;
                            const imageHeight = uploadImage.height;

                            // Set the logo width to be 80% of the image width
                            const logoResizedWidth = imageWidth * 0.4;

                            // Calculate the corresponding height to maintain the aspect ratio of the logo
                            const logoResizedHeight = (logoResizedWidth / logo.width) * logo.height;

                            let posX;
                            let posY;

                            if (size === "512x512") {
                                posX = (imageWidth / 10) * 0.5;
                                posY = (imageHeight / 10) * 9;
                            } else if (size === "512x768") {
                                posX = (imageWidth / 9) * 1;
                                posY = (imageHeight / 16) * 15;
                            } else {
                                posX = (imageWidth / 16) * 0.5;
                                posY = (imageHeight / 9) * 5.75;
                            }

                            // Draw the logo on the image
                            context.save();
                            context.globalAlpha = 0.5;
                            context.drawImage(logo, posX, posY, logoResizedWidth, logoResizedHeight);
                            context.restore();

                            // Return the watermarked image
                            return uploadImage;
                        })
                        .then(watermarkedImg => postImage.appendChild(watermarkedImg));
                } else {
                    image.src = APIimage;
                    postImage.append(image);

                }

                loader.classList.remove('show');
                image.classList.remove('hide');

            } else {
                // Handle the case where data.success is false
            }
        } catch (error) {
            console.log(error);
        } finally {
        }

    }




}
export default hubPage;