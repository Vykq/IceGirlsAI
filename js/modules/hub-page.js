const hubPage = () => {
    const images = document.querySelectorAll('.lazy');

    images.forEach(image => {
        if (image.classList.contains('watermarked-image')) {
            // Watermark
            const watermarkText = 'IceGirls.ai';
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            const tempImage = new Image();
            tempImage.onload = () => {
                canvas.width = tempImage.width;
                canvas.height = tempImage.height;

                context.drawImage(tempImage, 0, 0); // Draw the original image onto the canvas

                context.fillStyle = 'rgba(29, 29, 29, 1)'; // Black color with transparency
                context.fillRect(20, canvas.height - 60, canvas.width - 40, 40); // Draw black rectangle

                context.font = '20px Arial';
                context.fillStyle = 'rgba(255, 255, 255, 1)'; // Text color with transparency
                context.fillText(watermarkText, 30, canvas.height - 25); // Draw text

                // Update imageElement with combined content
                image.src = canvas.toDataURL('image/png');
                image.classList.add('show');
            };

            // Set the source of the temporary image to the original image source
            tempImage.src = image.getAttribute('data-src');
        }
    });
};

export default hubPage;