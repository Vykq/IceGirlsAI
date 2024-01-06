import checkTaskStatus from "./checkTaskStatus";
const lastUserTask = async (premiumBody) => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'checkLastTask');
    return postData(themeUrl.ajax_url, data)
        .then(async (id) => {
            console.log('last user task id', id);
            let lastTaskStatus = "Task completed";
            if(id !== "") {
                lastTaskStatus = await checkTaskStatus(id, premiumBody);
            }
            const dataset = {
                "taskID" : id,
                "status" : lastTaskStatus
            }
            return dataset;
        })
        .catch((error) => {
            console.log(error);
        });

}

export default lastUserTask;