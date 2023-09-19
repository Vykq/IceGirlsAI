const runPremium = (Id) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        redirect: 'follow'
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/task/" + Id + "/run", requestOptions)
        .then(response => response.json())
        .then(data => {
            return data.success;
        })
        .catch(error => console.error('error', error));

}

export default runPremium;