const useCredits = async () => {

    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }

    const data = new FormData();
    data.append('action', 'tokkens_used');

    return postData(themeUrl.ajax_url, data)
        .then((res) => {
            console.log('tokens left',res);
            const tokkensLeft = res.tokkens;
            if(document.querySelector('#userTokkens')) {
                document.querySelector('#userTokkens').textContent = tokkensLeft;
            }
        })
        .catch((error) => {
            console.log(error);
        });


}

export default useCredits;