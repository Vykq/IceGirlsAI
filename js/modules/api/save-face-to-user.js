import addNewFaceToUI from "../add-new-face-to-ui";
const saveFaceToUser = async (taskID) => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'saveFaceToUserTask');
    data.append('taskID', taskID);
    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            console.log('Face saved');
        })
        .catch((error) => {
            console.log(error);
        });


}

export default saveFaceToUser;