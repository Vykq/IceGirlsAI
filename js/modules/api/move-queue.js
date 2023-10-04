const moveQueue = (ID, overID, isPremium) => {

    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        redirect: 'follow'
    };

    let apiUrl = themeUrl.apiUrl;
    if(!isPremium){
        apiUrl = themeUrl.apiUrlFree;
    }

    return fetch(apiUrl + "agent-scheduler/v1/task/"+ ID +"/move/" + overID, requestOptions)
        .then(response => response.json())
        .then(data => {
        })
        .catch(error => console.error('error', error));
}
export default moveQueue;