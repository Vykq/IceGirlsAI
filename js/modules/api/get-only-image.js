import checkIfPremium from "../check-if-premium";
const getOnlyImage = async (faceid) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    let apiUrl = themeUrl.apiUrl;
    // if(!checkIfPremium()){
    //     apiUrl = themeUrl.apiUrlFree;
    // }

    return fetch(apiUrl + "agent-scheduler/v1/task/" + faceid + "/results?zip=false", requestOptions)
        .then(response => response.json())
        .then(data => {
            return data.data[0].image;
        })
        .catch(error => console.error('error', error));
}

export default getOnlyImage;