const getImage = (Id, isPremium) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    let apiUrl = themeUrl.apiUrl;

    return fetch(apiUrl + "agent-scheduler/v1/results/" + Id, requestOptions)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(!data.success === false){
                let image = data.data[0].image;
                let infotext = data.data[0].infotext;
                if(image) {
                    return {image, infotext};
                } else {
                    return 'error, no image';
                }
            } else {
                    apiUrl = themeUrl.apiUrlFree;
                    return fetch(apiUrl + "agent-scheduler/v1/results/" + Id, requestOptions)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if(!data.success === false) {
                                let image = data.data[0].image;
                                let infotext = data.data[0].infotext;
                                if (image) {
                                    return {image, infotext};
                                } else {
                                    return 'error, no image';
                                }
                            }
                        })
                        .catch(error => console.error('error', error));
            }

        })
        .catch(error => console.error('error', error));
}

export default getImage;