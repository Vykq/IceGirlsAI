const getPosition = (ID) => {


    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow',
        keepalive: true
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/task/"+ ID +"/position", requestOptions)
        .then(response => response.json())
        .then(data => {
            const pos = data.data.position;
            const status = data.data.status;
            return { pos, status };
        })
        .catch(error => console.error('error', error));
}
export default getPosition;