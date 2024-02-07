const creditsLeft = async () => {
    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'tokkens_left_for_user');

    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            return res.tokkens;
        })
        .catch((error) => {
            console.log(error);
        });


}

export default creditsLeft;