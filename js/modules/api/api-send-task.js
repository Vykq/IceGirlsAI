import getOnlyImage from "./get-only-image";

const apiSendTask = async (isPremium, oldSeed) => {
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

    const faces = document.querySelectorAll('input[name="face"]');
    let face = {
        taskid: '',
    }

    let stepSlider = '';
    let details = '';
    let isAtLeastOneChecked = false;
    const selectedValues = [];
    let midPrompt = "";
    let finalPrompt = "";
    let isFaceSelected = null;
    if(isPremium){
        //IF USER IS PREMIUM
        const stepInputElement = document.querySelector('input[name="steps"]');
        const promptInput = document.querySelector('textarea[name="prompt"]');
        details = document.querySelector('input[name="details"]').value;
        midPrompt = promptInput.value;
        stepSlider = stepInputElement.value;
    }else {
        if(document.querySelector('body').classList.contains('logged-in')){
            const promptInput = document.querySelector('textarea[name="prompt"]');
            midPrompt = promptInput.value;
        }

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

    faces.forEach(input =>{
        if(input.checked){
            face.taskid = input.id;
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

    let raw = {
        "enable_hr": true,
        "denoising_strength": 0.5,
        "hr_scale": 1.5,
        "hr_upscaler": "4xUltrasharp_4xUltrasharpV10",
        "prompt": finalPrompt,
        "width": imageSize.width,
        "height": imageSize.height,
        "negative_prompt": "(AS-Adult-Neg:1.3), (child:2), (kid:2)," + checkpoint.negative,
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
        // "steps": 20,
        "seed": oldSeed,
    };

    if (face.taskid !== "" && face.taskid !== "none") {
        try {
            const faceImage = await getOnlyImage(face.taskid);
            let reactorArgs = [
                faceImage, //Image source
                true, //enable reactor?
                "0", //comma seperated faces
                "0", //face numbers
                "inswapper_128.onnx", //inswapper model
                "CodeFormer", //
                1, //Restore visibility value
                false, //Restore face -> Upscale
                "4xUltrasharp_4xUltrasharpV10", //upscaller
                1.25, //Upscaler scale value
                1, //Upscaler visibility (if scale = 1)
                false, //Swap in source image
                true, //Swap in generated img
                2, //Console Log Level (0 - min, 1 - med or 2 - max)
                0,//Gender Detection (Source) (0 - No, 1 - Female Only, 2 - Male Only)
                0, // Gender Detection (Target) (0 - No, 1 - Female Only, 2 - Male Only)
                false, //save originla image made before swap
                0.5, //#17 CodeFormer Weight (0 = maximum effect, 1 = minimum effect), 0.5 - by default
                true, //source hash check
                false, // target hach check
                "CUDA",
                false, //face mask
                0, //from iamge
                0,
                0
            ];
            raw['alwayson_scripts'] = { "reactor": {
                "args": reactorArgs}
            } ;

            console.log('Face set');
        } catch (error) {
            console.error('Error fetching face image:', error);
        }
    }
    const requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: JSON.stringify(raw),
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
                //raw: JSON.parse(raw), // Return the raw object
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