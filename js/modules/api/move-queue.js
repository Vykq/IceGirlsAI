const moveQueue = (ID, overID) => {
    const whiteBlock = document.querySelector('#current-step')
    const orangeBlock = document.querySelector('#steps-all');
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        redirect: 'follow'
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/task/"+ ID +"/move/" + overID, requestOptions)
        .then(response => response.json())
        .then(data => {
            whiteBlock.textContent = 'Your task will be done after last PREMIUM user task';

        })
        .catch(error => console.error('error', error));
}
export default moveQueue;