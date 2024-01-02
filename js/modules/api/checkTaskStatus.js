const checkTaskStatus = (Id, isPremium) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    let apiUrl = themeUrl.apiUrl;
    if(!isPremium){
        apiUrl = themeUrl.apiUrlFree;
    }

    return fetch(apiUrl + "agent-scheduler/v1/task/" + Id + "/results?zip=false", requestOptions)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.success){
                return true; //Done
            } else {
                return false;
            }

        })
        .catch(error => console.error('error', error));
}

export default checkTaskStatus;