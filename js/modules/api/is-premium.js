const isPremium = async (taskID) => {

    const form = document.querySelector('.creation-form');
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData(form);
    data.append('action', 'generate_image');
    data.append('taskID', taskID);
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            return res.premium;
        })
        .catch((error) => {
            console.log(error);
        });
}

export default isPremium;