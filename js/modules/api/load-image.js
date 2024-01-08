import watermark from "watermarkjs/lib";

const loadImage = async (image, isPremium, aspectRatio) => {
    const colWrapper = document.querySelector('.col-wrapper');
    const notify = colWrapper.querySelector('.notifier');
    const loader = colWrapper.querySelector('.spinner');
    const imageElement = colWrapper.querySelector('.generated-image');
    const generateButtons = colWrapper.querySelectorAll('.generate');
    const imageDiv = colWrapper.querySelector('.col-wrapper .image');
    let size;
    let imageToShow;
    if(isPremium){
        imageElement.src = image;
        imageElement.classList.add('show');
        generateButtons.forEach(btn => {
            btn.disabled = false;
        })
        loader.classList.remove('show');
    } else {
        const watermarkedImage = await watermark([image, themeUrl.themeUrl + '/assets/images/watermark.jpg'])
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

                if(aspectRatio == "9/16"){
                    size = "512x768"
                } else if(aspectRatio == "1/1"){
                    size = "512x512";
                } else {
                    size = "768x512";
                }

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
            .then(watermarkedImg => {
                console.log(watermarkedImg);
                imageElement.remove();
                imageDiv.append(watermarkedImg);
                watermarkedImg.classList.add('show');
                watermarkedImg.classList.add('generated-image');
                generateButtons.forEach(btn => {
                    btn.disabled = false;
                })
                loader.classList.remove('show');
            });

    }

};

export default loadImage;