const checkTaskStatus = async (Id, isPremium) => {
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
                console.log('Image created');
                return data.data.status;
            } else {
                console.log('Image is:', data.message);
                return data.message;
            }

        })
        .catch(error => console.error('error', error));
}

export default checkTaskStatus;