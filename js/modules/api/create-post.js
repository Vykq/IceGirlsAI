const createPost = async (image, infotext, taskID) => {
    async function addWatermark(image) {
        return new Promise((resolve) => {
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

                const watermarkedImage = new Image();
                watermarkedImage.src = canvas.toDataURL('image/png');
                resolve(watermarkedImage); // Resolve the Promise with the watermarked image
            };

            tempImage.src = image; // Set the source of the temporary image to the original image base64
        });
    }

    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: requestData,
            headers: headers,
        });

        return await res.json(); // Parse the response as JSON
    }
    const watermarkImg = await addWatermark(image);
    const requestData = new FormData();
    requestData.append('action', 'create_generated_post');
    requestData.append('image', image);
    requestData.append('watermarked-image', watermarkImg.src);
    requestData.append('infoText', infotext);
    requestData.append('task-id', taskID);
    console.log(watermarkImg.src);
    console.log(image);
    const headers = {
        'Connection': 'Keep-Alive', // Add the Keep-Alive header
    };


    return postData(themeUrl.ajax_url, requestData)
        .then((res) => {
            console.log(res);
        })
        .catch((error) => {
            console.log(error);
        });

}

export default createPost;