import switchGenerateButton from "./switch-generate-button";

const showQueueInfo = (Id, isPremium) => {

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

    if(Id === ""){
        return;
    }

    return fetch(apiUrl + "agent-scheduler/v1/task/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            if(!data){
            } else {
                return data.data.status;
            }

        })
        .catch(error => console.error('error', error));

}

export default showQueueInfo;