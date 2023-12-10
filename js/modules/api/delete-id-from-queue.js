import setCookie from "../createCookie";

const deleteIdFromQueue = (Id, isPremium) => {

    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    };

    let apiUrl = themeUrl.apiUrl;
    if(!isPremium){
        apiUrl = themeUrl.apiUrlFree;
    }

    return fetch(apiUrl + "agent-scheduler/v1/task/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            if(data.success){
                console.log('kill task');
                return true;
            } else {
                return false;
            }

        })
        .catch(error => console.error('error', error));
}

export default deleteIdFromQueue;