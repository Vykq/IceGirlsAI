const singleImageTwo = async () => {

    const mainInfoBlock = document.querySelector('#taskid');
    const taskID = document.querySelector('#taskid').dataset.id;
    const singleImage = document.querySelector('#singleImage');
    const imageArea = document.querySelector('.image-area');
    const infoList = document.querySelector('#infolist');
    const infoLoader = infoList.querySelector('.loaderis .spinner');
    const actionsChars = document.createElement('div');
    actionsChars.classList.add('actions-chars');
    mainInfoBlock.append(actionsChars);
    let seed = "";
    let styles = {
        'style' : '',
        'action' : '',
        'char' : '',
        'prompt' : '',
        'seed' : '',
    }

    if(document.querySelector('.reuse-settings')){
        document.querySelector('.reuse-settings').disabled = true;

        document.querySelector('.reuse-settings').addEventListener('click', (e) =>{
            e.preventDefault();
            const baseUrl = '/create/';
            const queryParams = [];

            for (const key in styles) {
                if (styles[key]) {
                    queryParams.push(`${key}=${encodeURIComponent(styles[key])}`);
                }
            }

            const queryString = queryParams.join('&');
            const url = baseUrl + (queryString ? `?${queryString}` : '');

            window.location.href = url; // Navigate to the new page
        })
    }



    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");
    let apiUrl = themeUrl.apiUrl;

        return fetch(apiUrl + "agent-scheduler/v1/task/" + taskID + "/results?zip=false")
            .then(response => response.json())
            .then(data => {
                if(data.success !== false){
                    let APIimage = data.data[0].image;
                    let infoText = data.data[0].infotext;
                    const imageElement = loadImage(APIimage);
                    const getInfoData = imageInfoData(apiUrl, taskID);
                    seed = getSeed(infoText);
                    const spinner = singleImage.querySelector('.spinner');
                    spinner.classList.remove('show');
                    imageElement.classList.add('hub-single-image');
                    imageElement.classList.add('show');
                    if(document.querySelector('.reuse-settings')){
                        document.querySelector('.reuse-settings').disabled = false;
                    }
                } else {
                    apiUrl = themeUrl.apiUrlFree;

                    return fetch(apiUrl + "agent-scheduler/v1/task/" + taskID + "/results?zip=false")
                        .then(response => response.json())
                        .then(data => {
                            if(data.success !== false){
                                let APIimage = data.data[0].image;
                                let infoText = data.data[0].infotext;
                                const imageElement = loadImage(APIimage);
                                const getInfoData = imageInfoData(apiUrl, taskID);
                                const seed = getSeed(infoText);
                                const spinner = singleImage.querySelector('.spinner');
                                spinner.classList.remove('show');
                                imageElement.classList.add('hub-single-image');
                                imageElement.classList.add('show');
                                if(document.querySelector('.reuse-settings')){
                                    document.querySelector('.reuse-settings').disabled = false;
                                }
                            }else {
                               //TODO: Error
                            }
                        })
                        .catch(retryError => {
                            console.error(retryError);
                            // Handle the retry error if needed
                        });
                }
            })
            .catch(error => {
                console.error(error); // Log the error for debugging purposes

                // Handle the error here and switch to the alternative API URL

            });




    function loadImage(APIimage){

            const singleWrapper = document.createElement('div');
            singleWrapper.classList.add('single-wrapper');
            singleImage.prepend(singleWrapper);

            const postImage = document.createElement('div');
            postImage.classList.add('post-image');
            singleWrapper.append(postImage);

            const imgEl = document.createElement('img');
            imgEl.classList.add('hub-single-image');
            imgEl.alt = "IceGirls.ai generated image"; //ADD prompt?
            imgEl.src = APIimage;
            postImage.append(imgEl);
            return imgEl;

        }

    function getSeed(infotext) {
        const seed = infotext.match(/Seed: (\d+)/);
        styles['seed'] = seed[1];
        return seed;
    }
    function imageInfoData(apiUrl, taskID){
        const myHeaders = new Headers();
        myHeaders.append("accept", "application/json");
        myHeaders.append("Content-Type", "application/json");


        return fetch(apiUrl + "agent-scheduler/v1/task/" + taskID)
            .then(response => response.json())
            .then(async (data) => {
                if(data.success === true){
                    console.log(data);
                    const checkPoint = data.data.params.checkpoint;
                    const height = data.data.params.height;
                    const width = data.data.params.width;
                    const imageSize = width + "x" + height;
                    const prompt = data.data.params.prompt;
                    const steps = data.data.params.steps;
                    const cleanPrompt = prompt.replace(/<lora:[^>]+>/g, '');
                    const checkPointNice = await getNiceCpName(checkPoint);

                    let imageClass = "normal";
                    if(imageSize == "512x512"){
                        imageClass = "square";
                    } else if (imageSize == "960x512"){
                        imageClass = 'horizontal';
                    }

                    singleImage.classList.add(imageClass);
                    imageArea.classList.add(imageClass);

                    const matches = prompt.match(/<lora:([^:]+):([^>]+)>/g);
                    const loraInfo = matches.map(match => {
                        const [, key, value] = match.match(/<lora:([^:]+):([^>]+)>/);
                        // Format the lora label as requested
                        const formattedLabel = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()).replace(/\d/g, '').replace('.', '').replace(' ', '');

                        return { key: formattedLabel, value };
                    });

                    const loraInfoWp = await getLoraInformation(matches);

                    const finalPrompt = cleanPrompTriggers(cleanPrompt, loraInfoWp);

                    styles['prompt'] = finalPrompt;

                    const infoItems = [
                        { label: "Size", value: imageSize },
                        { label: "Image Quality", value: steps },
                        { label: "Prompt", value: finalPrompt },
                    ]



                    loraInfo.forEach(lora => {
                        if(lora.key == "MoreDetails") {
                            infoItems.push({ label: lora.key, value: lora.value });
                        }
                    });



                    infoLoader.classList.remove('show');
                    infoItems.forEach(info => {
                        const listItem = document.createElement("p");
                        listItem.classList.add('info-title');
                        listItem.textContent = info.label + ": ";

                        const labelElement = document.createElement("span");
                        listItem.appendChild(labelElement);
                        const valueElement = document.createElement("span");
                        valueElement.textContent = info.value;
                        valueElement.classList.add("info-ans");
                        listItem.appendChild(valueElement);

                        infoList.appendChild(listItem);
                    });

                    createLoraOutputs(loraInfoWp, checkPointNice);
                }

            })
            .catch(error => {
                console.error(error);
            });

    }


    function cleanPrompTriggers(cleanPrompt, loraInfoWp){
        console.log('here');
        console.log(loraInfoWp);
        let finalPrompt = cleanPrompt;

        // Iterate through the "Actions" and "Chars" objects
        for (const key in loraInfoWp) {
            if (loraInfoWp.hasOwnProperty(key)) {
                const info = loraInfoWp[key];
                finalPrompt = finalPrompt.replace(info.trigger, '');
            }
        }

        finalPrompt = finalPrompt.replace(/^[, ]+/, '');
        console.log('final ' + finalPrompt)

        return finalPrompt;
    }

    function createLoraOutputs(loraInfoWp, style){
        createStyle(style);
        createActions(loraInfoWp.Actions);
        createChars(loraInfoWp.Chars);

    }


    function createStyle(style){
        if(style.length !== 0){
            styles['style'] = style.model;
            const styleWrapper = document.createElement('div');
            styleWrapper.classList.add('style-wrapper');
            actionsChars.append(styleWrapper);
            console.log(style);

            const title = document.createElement('p');
            title.classList.add('top');
            title.textContent = "Style";
            styleWrapper.append(title);

            const styleGrid = document.createElement('div');
            styleGrid.classList.add('chars-grid');
            styleWrapper.append(styleGrid);

            const singleStyle = document.createElement('div');
            singleStyle.classList.add('single-style');
            styleGrid.append(singleStyle);

            const wrapper = document.createElement('div');
            wrapper.classList.add('wrapper');
            singleStyle.append(wrapper);

            const styleInput = document.createElement('div');
            styleInput.classList.add('style-input');
            wrapper.append(styleInput);

            const label = document.createElement('label');
            label.textContent = style.model;
            styleInput.append(label);

            const styleImage = document.createElement('div');
            styleImage.classList.add('style-image');
            styleInput.append(styleImage);

            const image = document.createElement('img');
            image.src = style.image;
            styleImage.append(image);
        }
    }
    function createChars(chars){
            if(chars.length !== 0){
                styles['char'] = chars.title;
                const charsWrapper = document.createElement('div');
                charsWrapper.classList.add('chars-wrapper');
                actionsChars.append(charsWrapper);
                console.log(chars);

                const title = document.createElement('p');
                title.classList.add('top');
                title.textContent = "Charachter";
                charsWrapper.append(title);

                const charsGrid = document.createElement('div');
                charsGrid.classList.add('chars-grid');
                charsWrapper.append(charsGrid);

                const singleChar = document.createElement('div');
                singleChar.classList.add('single-char');
                charsGrid.append(singleChar);

                const wrapper = document.createElement('div');
                wrapper.classList.add('wrapper');
                singleChar.append(wrapper);

                const charInput = document.createElement('div');
                charInput.classList.add('char-input');
                wrapper.append(charInput);

                const label = document.createElement('label');
                label.textContent = chars.title;
                charInput.append(label);

                const charImage = document.createElement('div');
                charImage.classList.add('char-image');
                charInput.append(charImage);

                const image = document.createElement('img');
                image.src = chars.image;
                charImage.append(image);
            }

    }

    function createActions(actions){
        if(actions.length !== 0) {
            styles['action'] = actions.title;
            const actionsWrapper = document.createElement('div');
            actionsWrapper.classList.add('actions-wrapper');
            actionsChars.append(actionsWrapper);
            console.log(actions);

            const title = document.createElement('p');
            title.classList.add('top');
            title.textContent = "Actions";
            actionsWrapper.append(title);

            const actionsGrid = document.createElement('div');
            actionsGrid.classList.add('actions-grid');
            actionsWrapper.append(actionsGrid);

            const singleAction = document.createElement('div');
            singleAction.classList.add('single-action');
            actionsGrid.append(singleAction);

            const wrapper = document.createElement('div');
            wrapper.classList.add('wrapper');
            singleAction.append(wrapper);

            const actionInput = document.createElement('div');
            actionInput.classList.add('action-input');
            wrapper.append(actionInput);

            const label = document.createElement('label');
            label.textContent = actions.title;
            actionInput.append(label);

            const actionImage = document.createElement('div');
            actionImage.classList.add('action-image');
            actionInput.append(actionImage);

            const image = document.createElement('img');
            image.src = actions.image;
            actionImage.append(image);
        }


    }


    function getLoraInformation(loras){
        return new Promise((resolve, reject) => {
            const postData = async (url, data) => {
                let res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: requestData,
                });

                return await res.json(); // Parse the response as JSON
            }

            const requestData = new FormData();
            requestData.append('action', 'get_lora_info');
            requestData.append('loras', loras);

            postData(themeUrl.ajax_url, requestData)
                .then((res) => {
                    if (res) {
                        const Actions = res.actions;
                        const Chars = res.chars;
                        resolve({ Actions, Chars });
                    } else {
                        reject("Failed");
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }

    function getNiceCpName(name) {
        return new Promise((resolve, reject) => {
            const postData = async (url, data) => {
                let res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: requestData,
                });

                return await res.json(); // Parse the response as JSON
            }

            const requestData = new FormData();
            requestData.append('action', 'get_nice_cp_title');
            requestData.append('model', name);

            postData(themeUrl.ajax_url, requestData)
                .then((res) => {
                    if (res) {
                        console.log(res);
                        resolve(res);
                    } else {
                        reject("Failed to get nice CP title");
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }

}

export default singleImageTwo;