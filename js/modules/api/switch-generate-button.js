const switchGenerateButton = (button, status) =>{
    const stopBtn = document.querySelector('.stop-generate');
    const spinner = document.querySelector('.spinner');
    const notifier = document.querySelector('.notifier');
    const percents = document.querySelector('#steps-all');
    const queue = document.querySelector('#premium-queue');
    if(status === "start"){
        button.classList.add('hidden');
        stopBtn.classList.remove('hidden');
        spinner.classList.add('show');
        notifier.classList.add('hide');
        if(document.querySelector('.generated-image')){
            const img = document.querySelector('.generated-image');
            img.classList.remove('show');
        }
    } else if(status === "stopped") {
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        spinner.classList.remove('show');
        notifier.classList.remove('hide');
    } else if (status === "end") {
        spinner.classList.remove('show');
        notifier.classList.add('hide');
        button.classList.remove('hidden');
        stopBtn.classList.add('hidden');
    } else if (status === "upscale") {
        button.textContent = "Upscaling, please wait...";
        spinner.classList.add('show');
        notifier.classList.add('hide');
        percents.remove();
        queue.remove();
    } else if (status === "end-upscale") {
        button.textContent = "Upscaled";
        spinner.classList.remove('show');
        notifier.classList.add('hide');
        percents.remove();
        queue.remove();
        button.disabled = true;
    }

}

export default switchGenerateButton;