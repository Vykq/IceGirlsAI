
const showQueueInfo = (Id) => {

    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow',
        keepalive: true
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/task/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            return data.data.status;
        })
        .catch(error => console.error('error', error));

}

export default showQueueInfo;