const createPost = (image, infotext, taskID) => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: requestData,
            headers: headers,
        });

        return await res.json(); // Parse the response as JSON
    }
    const requestData = new FormData();
    requestData.append('action', 'create_generated_post');
    requestData.append('image', image);
    requestData.append('infoText', infotext);
    requestData.append('task-id', taskID);

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