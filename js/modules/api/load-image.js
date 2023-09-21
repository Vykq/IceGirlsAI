const loadImage = (image, isPremium) => {
    const notify = document.querySelector('.notifier');
    const loader = document.querySelector('.spinner');
    const imageElement = document.querySelector('.generated-image');
    const generateButton = document.querySelector('.generate');

    if(isPremium){
        imageElement.src = image;
        imageElement.classList.add('show');
        generateButton.disabled = false;
        loader.classList.remove('show');
    } else {

        //watermark
        const watermarkText = 'IceGirls.ai';
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        const tempImage = new Image();
        tempImage.onload = () => {
            canvas.width = tempImage.width;
            canvas.height = tempImage.height;

            context.drawImage(tempImage, 0, 0); // Draw the original image onto the canvas

            context.fillStyle = 'rgba(29, 29, 29, 1)'; // Black color with transparency
            context.fillRect((canvas.width / 9) * 6.5, (canvas.height / 16) * 14.75, 140, 40); // Draw black rectangle

            context.font = '20px Arial';
            context.fillStyle = 'rgba(255, 255, 255, 1)'; // Text color with transparency
            context.fillText(watermarkText, (canvas.width / 9) * 7, (canvas.height / 16) * 15.17); // Draw text

            imageElement.src = canvas.toDataURL('image/png'); // Update imageElement with combined content

            imageElement.classList.add('show');
            generateButton.disabled = false;
            loader.classList.remove('show');
        };

        tempImage.src = image; // Set the source of the temporary image to the original image base64
    }
};

export default loadImage;