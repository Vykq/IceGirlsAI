const apiSendTask = (isPremium) => {
    const myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");
    const form = document.querySelector('.creation-form');
    const tabContainer = document.querySelector('.tabs-container');
    const allRadios = tabContainer.querySelectorAll('input[type="radio"]');
    const allCheckboxes = tabContainer.querySelectorAll('input[type="checkbox"]');
    const allRadiosAndCheckboxes = tabContainer.querySelectorAll('input[type="radio"], input[type="checkbox"]');

    let imageSize = {
        width: 512,
        height: 960,
    }
    if(document.querySelector('input[name="aspect-ratio"]')){
        const imageArea = document.querySelector('.col-wrapper');
        const aspectRatioInput = document.querySelector('input[name="aspect-ratio"]:checked');
        imageArea.classList.remove('square', 'normal', 'horizontal');
        if(aspectRatioInput.value === "9/16"){
            imageSize = {
                width: 512,
                height: 960,
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
                width: 960,
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
        finalPrompt = midPrompt + ", " + selectedValuesString;
    } else {
        if(midPrompt === ""){
            const inputCount = allRadiosAndCheckboxes.length;
            const filteredInputs = Array.from(allRadiosAndCheckboxes).filter(input => input.name !== 'get-premium');
            const randomValues = getRandomValues(Array.from(filteredInputs), 5);
            let randomValuesString = randomValues.map(input => input.value).join(", ");
            if(isPremium){
                finalPrompt = midPrompt + ", " +randomValuesString;
            } else{
                finalPrompt = randomValuesString;
            }
        } else {
            finalPrompt = midPrompt;
        }


    }

    finalPrompt = addActionsToPrompt(finalPrompt, action, char);

    const raw = JSON.stringify({
        "prompt": finalPrompt,
        "width": imageSize.width,
        "height": imageSize.height,
        "negative_prompt": checkpoint.negative,
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
    });

    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow',
        referrerPolicy: "unsafe-url",
    };

    return fetch(themeUrl.apiUrl + "agent-scheduler/v1/queue/txt2img", requestOptions)
        .then(response => response.json())
        .then(data => {
            return data.task_id;
        })
        .catch(error => console.error('error', error));










    //ADD action LORA to prompt;
    function addActionsToPrompt(prompt, action, char){
        let finalPrompt;
        finalPrompt = char.triggerWord + ", " + action.triggerWord + prompt + ", " + char.loraInput + " " + action.loraInput + " <lora:more_details:" + details + ">";
        return finalPrompt
    }


    function getRandomValues(inputValues, count) {
        const shuffled = inputValues.sort(() => Math.random() - 0.5);
        return shuffled.slice(0, count);
    }
}

export default apiSendTask;