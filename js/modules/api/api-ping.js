const apiPing = async (isPremium) => {

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

    console.log(apiUrl);

    return fetch(apiUrl + "internal/ping", requestOptions)
        .then(response => response.json())
        .then(data => {
            if(data){
                console.log('server is on');
                return true;
            } else {
                console.log('server is off');
                return false;
            }
        })
        .catch(error => console.error('error', error));

}

export default apiPing;