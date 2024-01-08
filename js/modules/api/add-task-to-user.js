const addTaskToUser = async (taskID) => {
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
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            console.log(res.postid)
            return res.postid;
        })
        .catch((error) => {
            console.log(error);
        });
}

export default addTaskToUser;