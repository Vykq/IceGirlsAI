const deleteFace = async () => {
    console.log('deleteFace works')
    const deleteFaces = document.querySelectorAll('.delete-face');

    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        });

        return await res.json(); // Parse the response as JSON
    }



    if(deleteFaces) {
        deleteFaces.forEach(btn => {
            btn.addEventListener('click', async () => {
                const data = new FormData();
                data.append('action', 'deleteFaceFromUser');
                data.append('faceID', btn.dataset.id);
                return postData(themeUrl.ajax_url, data)
                    .then((res) => {
                        const blocks = document.querySelectorAll('.single-face')
                        blocks.forEach(block =>{
                            if(block.dataset.id === btn.dataset.id){
                                block.remove();
                            }
                        })
                        console.log(res);
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            })
        })
    }
}

export default deleteFace;