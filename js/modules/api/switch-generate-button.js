const switchGenerateButton = (button, status) =>{
    const stopBtn = document.querySelector('.stop-generate');
    const generateBtn = document.querySelector('.generate');
    const spinner = document.querySelector('.spinner');
    const loader = spinner.querySelector('.loader');
    const notifier = document.querySelector('.notifier');
    const percents = document.querySelector('#steps-all');
    const queue = document.querySelector('#premium-queue');
    const currentStep = document.querySelector('#current-step');
    const sameSeedBtn = document.querySelector('.seed-button');
    if(status === "start"){
        button.classList.add('hidden');
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
    } else if(status === "stopped") {
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        spinner.classList.remove('show');
        notifier.classList.remove('hide');
        sameSeedBtn.classList.add('hidden');
        queue.textContent = "";
    } else if (status === "end") {
        spinner.classList.remove('show');
        notifier.classList.add('hide');
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        sameSeedBtn.classList.remove('hidden');

        if(document.querySelector('.upscale')){
            const upscaleButton = document.querySelector('.upscale');
            upscaleButton.classList.remove('hidden');
            upscaleButton.disabled = false;
            upscaleButton.textContent = "Upscale & download!";
            document.querySelector('.upscale-text').classList.remove('hidden');
        }

    } else if (status === "upscale") {
        button.textContent = "Upscaling, please wait...";
        spinner.classList.add('show');
        notifier.classList.add('hide');
        percents.classList.add('hide');
        queue.classList.add('hide');
        button.disabled = true;
        sameSeedBtn.classList.add('hidden');
        currentStep.textContent = "Upscalling...";
        generateBtn.disabled = true;
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
    } else if (status === "error"){
        loader.classList.add('hide');
        notifier.classList.add('show');
        sameSeedBtn.classList.add('hidden');
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        percents.classList.remove('hide');
    }

}

export default switchGenerateButton;