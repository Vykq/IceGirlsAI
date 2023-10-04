const getPosition = (ID, isPremium) => {


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

    return fetch(apiUrl + "agent-scheduler/v1/task/"+ ID +"/position", requestOptions)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const pos = data.data.position;
            const status = data.data.status;
            return { pos, status };
        })
        .catch(error => {
                return error;
            }
        );
}
export default getPosition;