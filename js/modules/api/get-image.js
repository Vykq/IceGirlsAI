const getImage = (Id) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/results/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            let image = data.data[0].image;
            let infotext = data.data[0].infotext;
            if(image) {
                return {image, infotext};
            } else {
                return 'error, no image';
            }
        })
        .catch(error => console.error('error', error));
}

export default getImage;