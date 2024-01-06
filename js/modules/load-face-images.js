import getOnlyImage from "./api/get-only-image";

const loadFaceImages = async () =>{

    const facesBlock = document.querySelectorAll('.single-face');
    const imageElements = document.querySelectorAll('.face-image');
    if(facesBlock.length !== 0){
        facesBlock.forEach(singleFace => {
            const faceId = singleFace.querySelector('input[name="face"]').id;
            const input = singleFace.querySelector('input');
            const loader = singleFace.querySelector('.loader');
            console.log(faceId);
            //Load image
            getOnlyImage(faceId)
                .then((res) => {
                    imageElements.forEach(imgEl => {
                        if(input.dataset.imgid == imgEl.alt){
                            loader.classList.add('hide')
                            imgEl.src = res;
                        }
                    })
                });
        })
    }

}

export default loadFaceImages;