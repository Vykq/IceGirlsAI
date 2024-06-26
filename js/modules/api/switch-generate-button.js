import setCookie from "../createCookie";

const switchGenerateButton = (button, status) =>{
    const stopBtn = document.querySelector('.stop-generate');
    const generateBtn = document.querySelector('.generate');
    const generateBtn2 = document.querySelector('.gen-bottom');
    const colWrapper = document.querySelector('.col-wrapper');
    const spinner = colWrapper.querySelector('.spinner');
    const loader = colWrapper.querySelector('.loader');
    const notifier = document.querySelector('.notifier');
    const percents = document.querySelector('#steps-all');
    const queue = document.querySelector('#premium-queue');
    const currentStep = document.querySelector('#current-step');
    const sameSeedBtn = document.querySelector('.seed-button');
    const saveFaceBtn = document.querySelector('.saveface');
    if(status === "start"){
        stopBtn.disabled = false;
        generateBtn.classList.add('hidden');
        generateBtn2.classList.add('hidden');
        stopBtn.classList.remove('hidden');
        spinner.classList.add('show');
        notifier.classList.add('hide');
        percents.classList.remove('hide');
        queue.classList.remove('hide');
        queue.textContent = "Queue: calculating...";
        currentStep.textContent = "";
        sameSeedBtn.classList.add('hidden');
        if(document.querySelector('.generated-image')){
            const img = document.querySelector('.generated-image');
            img.classList.remove('show');
        }
        if(document.querySelector('.upscale')){
            const upscaleButton = document.querySelector('.upscale');
            upscaleButton.classList.add('hidden');
            document.querySelector('.upscale-text').classList.add('hidden');
        }
        if(saveFaceBtn){
            saveFaceBtn.classList.add('hidden');
        }
    } else if(status === "stopped") {
        stopBtn.disabled = false;
        generateBtn.classList.remove('hidden');
        generateBtn2.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        spinner.classList.remove('show');
        notifier.classList.remove('hide');
        sameSeedBtn.classList.add('hidden');
        queue.textContent = "";
        //setCookie('lastGeneratedId', '',1);
    } else if (status === "end") {
        stopBtn.disabled = false;
        spinner.classList.remove('show');
        notifier.classList.add('hide');
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        sameSeedBtn.classList.remove('hidden');
        setCookie('lastGeneratedId', '',1);
        if(document.querySelector('.upscale')){
            const upscaleButton = document.querySelector('.upscale');
            upscaleButton.classList.remove('hidden');
            upscaleButton.disabled = false;
            upscaleButton.textContent = "Upscale & download!";
            document.querySelector('.upscale-text').classList.remove('hidden');
        }
        if(saveFaceBtn){
            saveFaceBtn.classList.remove('hidden');
        }

    } else if (status === "upscale") {
        button.textContent = "Upscaling, please wait...";
        spinner.classList.add('show');
        notifier.classList.add('hide');
        percents.classList.add('hide');
        queue.classList.add('hide');
        button.disabled = true;
        //sameSeedBtn.classList.add('hidden');
        currentStep.textContent = "Upscalling...";
        generateBtn.disabled = true;
        generateBtn2.disabled = true;
    } else if (status === "end-upscale") {
        button.textContent = "Upscaled";
        spinner.classList.remove('show');
        notifier.classList.add('hide');
        percents.classList.add('hide');
        queue.classList.add('hide');
        sameSeedBtn.classList.remove('hidden');
        currentStep.classList.add('hide');
        button.disabled = true;
        generateBtn.disabled = false;
        generateBtn2.disabled = false;
    } else if (status === "error"){
        loader.classList.add('hide');
        notifier.classList.add('show');
        sameSeedBtn.classList.add('hidden');
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        percents.classList.remove('hide');
        stopBtn.disabled = false;
    } else if (status === "already-generating"){
        generateBtn.classList.add('hidden');
        generateBtn2.classList.add('hidden');
        stopBtn.classList.remove('hidden');
        stopBtn.disabled = true;
        spinner.classList.add('show');
        notifier.classList.add('hide');
        percents.classList.remove('hide');
        queue.classList.remove('hide');
        queue.textContent = "Your previous task is not done yet.";
        currentStep.textContent = "Your previous task is not done yet.";
        sameSeedBtn.classList.add('hidden');
        if(document.querySelector('.generated-image')){
            const img = document.querySelector('.generated-image');
            img.classList.remove('show');
        }
        if(document.querySelector('.upscale')){
            const upscaleButton = document.querySelector('.upscale');
            upscaleButton.classList.add('hidden');
            document.querySelector('.upscale-text').classList.add('hidden');
        }
        if(saveFaceBtn){
            saveFaceBtn.classList.add('hidden');
        }
    }
}

export default switchGenerateButton;