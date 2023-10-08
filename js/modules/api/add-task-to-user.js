const addTaskToUser = async (taskID, raw) => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'addTaskToUser');
    data.append('taskID', taskID);
    data.append('infoText', JSON.stringify(raw));
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            return res.postid;
        })
        .catch((error) => {
            console.log(error);
        });
}

export default addTaskToUser;