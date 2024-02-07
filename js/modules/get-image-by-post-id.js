const getImageByPostId = async (postid) => {

    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'getImageBase64ByPostID');
    data.append('id', postid);
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
          return res.image;
        })
        .catch((error) => {
            console.log(error);
        });

}

export default getImageByPostId;