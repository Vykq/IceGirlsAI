const upscaleImage = (isPremium, image) => {
    if(isPremium){
        const myHeaders = new Headers();
        myHeaders.append("accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        const requestOptions = {
            method: 'POST',
            headers: myHeaders,
            redirect: 'follow',
            body: JSON.stringify({
                "resize_mode": 0,
                "show_extras_results": true,
                "gfpgan_visibility": 0,
                "codeformer_visibility": 0,
                "codeformer_weight": 0,
                "upscaling_resize": 3.5,
                "upscaling_crop": false,
                "upscaler_1": "4xUltrasharp_4xUltrasharpV10",
                "upscaler_2": "4xUltrasharp_4xUltrasharpV10",
                "extras_upscaler_2_visibility": 1,
                "upscale_first": true,
                "image": image
            })
        };

        return fetch(themeUrl.apiUrl + "sdapi/v1/extra-single-image", requestOptions)
            .then(response => response.json())
            .then(data => {
                const upscaledImage = data.image;

                // Create a Blob from the base64 upscaled image data
                const blob = dataURItoBlob(upscaledImage);

                // Create a download link
                const downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(blob);
                downloadLink.download = 'upscaled_image.png'; // Specify the desired file name here

                // Trigger a click on the download link to initiate the download
                downloadLink.click();

                // Clean up by revoking the Blob URL
                URL.revokeObjectURL(downloadLink.href);

                return upscaledImage;
            })
            .catch(error => console.error('error', error));
    } else {
        const modal = document.querySelector('.premium-modal');
        modal.classList.add('show');
        return false;
    }

    function dataURItoBlob(dataURI) {
        // Ensure the dataURI starts with a MIME type declaration
        const fullDataURI = "data:image/png;base64," + dataURI;

        const byteString = atob(fullDataURI.split(',')[1]);
        const mimeString = fullDataURI.split(',')[0].split(':')[1].split(';')[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: mimeString });
    }



}

export default upscaleImage;