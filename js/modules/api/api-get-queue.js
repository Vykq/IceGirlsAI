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
            const currentTaskId = data.current_task_id;
            return { currentTaskId };
        })
        .catch(error => console.error('error', error));

}

export default apiGetQueue;