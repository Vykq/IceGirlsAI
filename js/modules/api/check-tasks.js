const checkTasks = async (pendingTaskIds, taskID) => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }


    const data = new FormData();
    data.append('action', 'premium_tasks');
    data.append('taskID', taskID);
    data.append('pendingTaskIds', pendingTaskIds);

    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            return res.position;
        })
        .catch((error) => {
            console.log(error);
        });
}

export default checkTasks;