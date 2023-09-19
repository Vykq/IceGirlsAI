const likeImageAjax = () => {

    const addButton = document.querySelector('.add-to-favorites');

    addButton.addEventListener('click', (e) => {
        e.preventDefault();
        const postData = async (url, data) => {
            let res = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                body: requestData,
            });

            return await res.json(); // Parse the response as JSON
        }
        const requestData = new FormData();
        requestData.append('action', 'like_image');
        requestData.append('postID', addButton.dataset.id);


        return postData(themeUrl.ajax_url, requestData)
            .then((res) => {
                if(res.status == "success"){
                    var imageElement = document.createElement('img');
                    imageElement.src = themeUrl.themeUrl + '/assets/images/liked.svg';
                    var countElement = document.createElement('span');
                    countElement.textContent = res.count;

                    // Clear the existing content of addButton
                    addButton.innerHTML = '';

                    // Append the image, space, and count to addButton
                    addButton.appendChild(imageElement);
                    addButton.appendChild(countElement);
                    location.reload();

                }
            })
            .catch((error) => {
                console.log(error);
            });

    })
}

export default likeImageAjax;