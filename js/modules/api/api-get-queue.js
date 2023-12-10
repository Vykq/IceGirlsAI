const apiGetQueue = (isPremium) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow',
        keepalive: true
    };

    let apiUrl = themeUrl.apiUrl;
    if(!isPremium){
        apiUrl = themeUrl.apiUrlFree;
    }

    return fetch(apiUrl + "agent-scheduler/v1/queue", requestOptions)
        .then(response => response.json())
        .then(data => {
            //console.log(data);
            console.log(data);
            const pendingTasks = data.pending_tasks;
            const currentTaskId = data.current_task_id;
            const totalPendingTasks = data.total_pending_tasks;
            const taskObjects = [];
            for (const task of pendingTasks) {
                const taskId = task.id;
                const taskType = task.type;

                const taskObject = {
                    id: taskId,
                    type: taskType,
                    // ... add other properties as needed
                };
                taskObjects.push(taskObject);
            }
            // if(!currentTaskId){
            //     return;
            // }
            return { currentTaskId, totalPendingTasks, pendingTasks, taskObjects };
        })
        .catch(error => console.error('error', error));

}

export default apiGetQueue;