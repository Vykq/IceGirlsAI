import getOnlyImage from "./api/get-only-image";

const addNewFaceToUI = async (taskID) => {

    //where to add
    const facesContainer = document.querySelector('.user-faces .actions');
    const discordBlock = facesContainer.querySelector('a.discord-btn');
    let facesLength = document.querySelectorAll('.single-face').length;
    let facesBlocks = document.querySelectorAll('.single-face');
    let lastFaceBlock = facesBlocks.item(facesBlocks.length - 1);

    if(facesLength === 11){
        facesBlocks[0].remove();
    }
    facesLength = facesLength + 1;
    console.log('Face to ui added');



    await createNewFace();
    async function createNewFace(){


        const singleAction = document.createElement('div');
        singleAction.classList.add('single-action');
        singleAction.classList.add('single-face');
        singleAction.dataset.id = taskID;

        const wrapper = document.createElement('div');
        wrapper.classList.add('wrapper');
        singleAction.append(wrapper);

        const actionInputEl = document.createElement('div');
        actionInputEl.classList.add('action-input');
        wrapper.append(actionInputEl);

        const input = document.createElement('input');
        input.type = "radio";
        input.name = "face";
        input.dataset.imgid = "Face - " + facesLength;
        input.id = taskID;
        actionInputEl.append(input);

        const label = document.createElement('label');
        label.htmlFor = taskID;
        label.textContent = "Face - " + facesLength;
        actionInputEl.append(label);

        const faceImageWrap = document.createElement('div');
        faceImageWrap.classList.add('action-image');
        faceImageWrap.classList.add('face-image-wrap');
        actionInputEl.append(faceImageWrap);


        //delete Btn
        const deleteFace = document.createElement('div');
        deleteFace.classList.add('delete-face');
        deleteFace.title = "Delete face";
        deleteFace.dataset.id = taskID;

        const svgDelete = document.createElement('svg');
        svgDelete.innerHTML = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="handle" d="M12 2.75C11.0215 2.75 10.1871 3.37503 9.87787 4.24993C9.73983 4.64047 9.31134 4.84517 8.9208 4.70713C8.53026 4.56909 8.32557 4.1406 8.46361 3.75007C8.97804 2.29459 10.3661 1.25 12 1.25C13.634 1.25 15.022 2.29459 15.5365 3.75007C15.6745 4.1406 15.4698 4.56909 15.0793 4.70713C14.6887 4.84517 14.2602 4.64047 14.1222 4.24993C13.813 3.37503 12.9785 2.75 12 2.75Z" fill="#ff950d"></path> <path class="cover" d="M2.75 6C2.75 5.58579 3.08579 5.25 3.5 5.25H20.5001C20.9143 5.25 21.2501 5.58579 21.2501 6C21.2501 6.41421 20.9143 6.75 20.5001 6.75H3.5C3.08579 6.75 2.75 6.41421 2.75 6Z" fill="#ff950d"></path> <path d="M5.91508 8.45011C5.88753 8.03681 5.53015 7.72411 5.11686 7.75166C4.70356 7.77921 4.39085 8.13659 4.41841 8.54989L4.88186 15.5016C4.96735 16.7844 5.03641 17.8205 5.19838 18.6336C5.36678 19.4789 5.6532 20.185 6.2448 20.7384C6.83639 21.2919 7.55994 21.5307 8.41459 21.6425C9.23663 21.75 10.2751 21.75 11.5607 21.75H12.4395C13.7251 21.75 14.7635 21.75 15.5856 21.6425C16.4402 21.5307 17.1638 21.2919 17.7554 20.7384C18.347 20.185 18.6334 19.4789 18.8018 18.6336C18.9637 17.8205 19.0328 16.7844 19.1183 15.5016L19.5818 8.54989C19.6093 8.13659 19.2966 7.77921 18.8833 7.75166C18.47 7.72411 18.1126 8.03681 18.0851 8.45011L17.6251 15.3492C17.5353 16.6971 17.4712 17.6349 17.3307 18.3405C17.1943 19.025 17.004 19.3873 16.7306 19.6431C16.4572 19.8988 16.083 20.0647 15.391 20.1552C14.6776 20.2485 13.7376 20.25 12.3868 20.25H11.6134C10.2626 20.25 9.32255 20.2485 8.60915 20.1552C7.91715 20.0647 7.54299 19.8988 7.26957 19.6431C6.99616 19.3873 6.80583 19.025 6.66948 18.3405C6.52891 17.6349 6.46488 16.6971 6.37503 15.3492L5.91508 8.45011Z" fill="#ff950d"></path> <path d="M9.42546 10.2537C9.83762 10.2125 10.2051 10.5132 10.2464 10.9254L10.7464 15.9254C10.7876 16.3375 10.4869 16.7051 10.0747 16.7463C9.66256 16.7875 9.29502 16.4868 9.25381 16.0746L8.75381 11.0746C8.71259 10.6625 9.0133 10.2949 9.42546 10.2537Z" fill="#ff950d"></path> <path d="M15.2464 11.0746C15.2876 10.6625 14.9869 10.2949 14.5747 10.2537C14.1626 10.2125 13.795 10.5132 13.7538 10.9254L13.2538 15.9254C13.2126 16.3375 13.5133 16.7051 13.9255 16.7463C14.3376 16.7875 14.7051 16.4868 14.7464 16.0746L15.2464 11.0746Z" fill="#ff950d"></path> </g></svg>';

        deleteFace.append(svgDelete);
        actionInputEl.append(deleteFace);

        const spinner = document.createElement('div');
        spinner.classList.add('spinner');
        spinner.classList.add('show');
        faceImageWrap.append(spinner);


        const loader = document.createElement('span');
        loader.classList.add('loader');
        spinner.append(loader);

        const imgEl = document.createElement('img');
        imgEl.dataset.id = taskID;
        imgEl.alt = taskID;
        imgEl.classList.add('face-image');
        imgEl.classList.add('face-' + facesLength);
        spinner.append(imgEl);

        try {
            const res = await getOnlyImage(taskID);
            loader.classList.add('hide');
            imgEl.src = res;
        } catch (error) {
            console.error('Error loading face image:', error);
        }

        discordBlock.before(singleAction);
    }

}

export default addNewFaceToUI;