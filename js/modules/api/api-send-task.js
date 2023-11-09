const apiSendTask = (isPremium, oldSeed) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");
    const form = document.querySelector('.creation-form');
    const tabContainer = document.querySelector('.tabs-container');
    const allRadios = tabContainer.querySelectorAll('input[type="radio"]');
    const allCheckboxes = tabContainer.querySelectorAll('input[type="checkbox"]');
    const allRadiosAndCheckboxes = tabContainer.querySelectorAll('input[type="radio"], input[type="checkbox"]');

    let seed;







    let imageSize = {
        width: 512,
        height: 768,
    }


    if(document.querySelector('input[name="aspect-ratio"]')){
        const imageArea = document.querySelector('.col-wrapper');
        const aspectRatioInput = document.querySelector('input[name="aspect-ratio"]:checked');
        imageArea.classList.remove('square', 'normal', 'horizontal');
        if(aspectRatioInput.value === "9/16"){
            imageSize = {
                width: 512,
                height: 768,
            }
            imageArea.classList.add('normal');
        } else if(aspectRatioInput.value === "1/1"){
            imageSize = {
                width: 512,
                height: 512,
            }
            imageArea.classList.add('square');
        } else {
            imageSize = {
                width: 768,
                height: 512,
            }
            imageArea.classList.add('horizontal');
        }



    } else {

    }


    const checkpoints = document.querySelectorAll('input[name="checkpoint"]');
    let checkpoint = {
        sampler: '',
        name: '',
        cfg: '',
        negative: '',
    };
    const actions = document.querySelectorAll('input[name="action"]');
    let action = {
        triggerWord: '',
        loraInput: '',
    }

    const chars = document.querySelectorAll('input[name="char"]');
    let char = {
        triggerWord: '',
        loraInput: '',
    }

    let stepSlider = '';
    let details = '';
    let isAtLeastOneChecked = false;
    const selectedValues = [];
    let midPrompt = "";
    let finalPrompt = "";
    if(isPremium){
        //IF USER IS PREMIUM
        const stepInputElement = document.querySelector('input[name="steps"]');
        const promptInput = document.querySelector('textarea[name="prompt"]');
        details = document.querySelector('input[name="details"]').value;
        midPrompt = promptInput.value;
        stepSlider = stepInputElement.value;
    }else {
        stepSlider = 20;
        details = 0;
    }

    checkpoints.forEach(input =>{
        if(input.checked){
            checkpoint.name = input.value;
            checkpoint.sampler = input.dataset.id;
            checkpoint.cfg = input.dataset.cfg || "7";
            checkpoint.negative = input.dataset.neg;
        }
    });

    allRadiosAndCheckboxes.forEach(input => {
        if (input.checked) {
            selectedValues.push(input.value);
            selectedValues.push(input.dataset.lora);
            isAtLeastOneChecked = true;
        }
    });

    actions.forEach(input =>{
        if(input.checked){
            action.triggerWord = input.value;
            action.loraInput = input.dataset.id;
        }
    });

    chars.forEach(input =>{
        if(input.checked){
            char.triggerWord = input.value;
            char.loraInput = input.dataset.id;
        }
    });

    if(isAtLeastOneChecked) {
        //jeigu yra pazymeje nors 1
        const selectedValuesString = selectedValues.join(', ');
        console.log(selectedValuesString);
        finalPrompt = midPrompt + ", " + selectedValuesString;
    } else {
        if(midPrompt === ""){


            chars.forEach(input =>{
                if (input.checked && input.id === "none") {
                    const inputCount = allRadiosAndCheckboxes.length;
                    const filteredInputs = Array.from(allRadiosAndCheckboxes).filter(input => input.name !== 'get-premium');
                    const randomValues = getRandomValues(Array.from(filteredInputs), 5);
                    let randomValuesString = randomValues.map(input => input.value).join(", ");

                    // Filter out empty data-lora values
                    let randomValuesLoras = randomValues.map(input => input.dataset.lora).filter(Boolean).join(", ");
                    console.log(randomValuesLoras);
                    if (isPremium) {
                        finalPrompt = midPrompt + ", " + randomValuesString + " " + randomValuesLoras;
                    } else {
                        finalPrompt = randomValuesString + " " + randomValuesLoras;
                    }
                }
            });
        } else {
            finalPrompt = midPrompt;
        }


    }

    finalPrompt = addActionsToPrompt(finalPrompt, action, char);

    const raw = JSON.stringify({
        "enable_hr": true,
        "denoising_strength": 0.35,
        "hr_scale": 1.2,
        "hr_upscaler": "4xUltrasharp_4xUltrasharpV10",
        "prompt": finalPrompt,
        "width": imageSize.width,
        "height": imageSize.height,
        "negative_prompt": "(child:2), (kid:2)," + checkpoint.negative,
        "override_settings": ({
            "sd_model_checkpoint" : checkpoint.name,
        }),
        "sampler_name": checkpoint.sampler,
        "sampler_index": checkpoint.sampler,
        "cfg_scale" : +checkpoint.cfg,
        "styles": [
            "string"
        ],
        "steps": +stepSlider,
        "seed": oldSeed,
        "restore_faces": true,
    });

    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow',
        referrerPolicy: "unsafe-url",
    };

    let apiUrl = themeUrl.apiUrl;
    if(!isPremium){
        apiUrl = themeUrl.apiUrlFree;
    }

    return fetch(apiUrl + "agent-scheduler/v1/queue/txt2img", requestOptions)
        .then(response => response.json())
        .then(data => {
            return {
                task_id: data.task_id, // Return task_id
                raw: JSON.parse(raw), // Return the raw object
            };
        })
        .catch(error => console.error('error', error));










    //ADD action LORA to prompt;
    // function addActionsToPrompt(prompt, action, char){
    //     let finalPrompt;
    //     finalPrompt = char.triggerWord + ", " + action.triggerWord + " " + prompt + ", " + char.loraInput + " " + action.loraInput + " <lora:more_details:" + details + ">";
    //     return finalPrompt
    // }

    function addActionsToPrompt(prompt, action, char) {
        const triggerPairs = [
            { trigger: char.triggerWord, value: char.loraInput },
            { trigger: action.triggerWord, value: action.loraInput },
            // Add more trigger pairs as needed
        ];

        let finalPrompt = "";

        for (const { trigger, value } of triggerPairs) {
            if (trigger) {
                finalPrompt += trigger;
            }


            if (value) {
                finalPrompt += ", " + value;
            }


        }
        if(prompt){
            finalPrompt += " " + prompt;
        }

        finalPrompt += " <lora:more_details:" + details + ">";
        return finalPrompt;
    }


    function getRandomValues(inputValues, count) {
        const shuffled = inputValues.sort(() => Math.random() - 0.5);
        return shuffled.slice(0, count);
    }
}

export default apiSendTask;