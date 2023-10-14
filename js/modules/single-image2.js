const singleImageTwo = () => {

    const taskID = document.querySelector('#taskid').dataset.id;
    const singleImage = document.querySelector('#singleImage');
    const infoList = document.querySelector('#infolist');
    const infoLoader = infoList.querySelector('.loaderis .spinner');
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
                    const seed = getSeed(infoText);

                    imageElement.classList.add('hub-single-image');
                    imageElement.classList.add('show');
                } else {
                    apiUrl = themeUrl.apiUrlFree;

                    return fetch(apiUrl + "agent-scheduler/v1/task/" + taskID + "/results?zip=false")
                        .then(response => response.json())
                        .then(data => {
                            if(data.success !== false){
                                let APIimage = data.data[0].image;
                                const imageElement = loadImage(APIimage);
                                imageElement.classList.add('hub-single-image');
                                imageElement.classList.add('show');
                            } else {
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

            const spinner = singleImage.querySelector('.spinner');
            spinner.classList.remove('show');

            const imgEl = document.createElement('img');
            imgEl.classList.add('hub-single-image');
            imgEl.alt = "IceGirls.ai generated image"; //ADD prompt?
            imgEl.src = APIimage;
            postImage.append(imgEl);
            return imgEl;

        }

    function getSeed(infotext) {
        const seed = infotext.match(/Seed: (\d+)/);
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

                    const infoItems = [
                        { label: "Checkpoint", value: checkPointNice },
                        { label: "Size", value: imageSize },
                        { label: "Image Quality", value: steps },
                        { label: "Prompt", value: cleanPrompt },
                    ]
                    const matches = prompt.match(/<lora:([^:]+):([^>]+)>/g);
                    const loraInfo = matches.map(match => {
                        const [, key, value] = match.match(/<lora:([^:]+):([^>]+)>/);
                        // Format the lora label as requested
                        const formattedLabel = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()).replace(/\d/g, '').replace('.', '').replace(' ', '');

                        return { key: formattedLabel, value };
                    });

                    loraInfo.forEach(lora => {
                        infoItems.push({ label: lora.key, value: lora.value });
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
                    console.log(loraInfo)
                }

            })
            .catch(error => {
                console.error(error);
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
                        resolve(res.model);
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