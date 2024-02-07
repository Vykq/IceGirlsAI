const saveFaceWithImage = async () => {

    const imageSrc = document.querySelector('.generated-image').src;
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'saveFaceImageToUser');
    data.append('image', imageSrc);
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            console.log('Face saved');
            return res.postid;
        })
        .catch((error) => {
            console.log(error);
        });

}

export default saveFaceWithImage;