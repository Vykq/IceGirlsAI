const deleteIdFromQueue = (Id) => {

    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/task/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            if(data.success){
                return true;
            } else {
                return false;
            }

        })
        .catch(error => console.error('error', error));
}

export default deleteIdFromQueue;