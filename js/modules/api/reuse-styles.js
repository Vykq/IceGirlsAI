const reuseStyles = () => {

    const modelTitle = document.querySelector('.choose-model');
    const actionTitle = document.querySelector('.choose-scene');
    const charTitle = document.querySelector('.choose-char');

    const detailsInput = document.querySelector('input[name="details"]');
    const detailsValue = document.querySelector('#details-value');
    const stepInput = document.querySelector('input[name="steps"]');
    const stepValue = document.querySelector('#quality-value');
    const aspectRatioInput = document.querySelector('input[name="aspect-ratio"]');


    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;

    }

    const style = findGetParameter('style');
    const action = findGetParameter('action');
    const char = findGetParameter('char');
    const details = findGetParameter('details');
    const steps = findGetParameter('steps');
    const size = findGetParameter('size');

    console.log(style);
    if(style){
        modelTitle.textContent = "Style: " + style;
    }
    if(action){
        actionTitle.textContent = "Action: " + action;
    }
    if(char){
        charTitle.textContent = "Char: " + char;
    }
    if(details){
        detailsInput.value = details;
        detailsValue.textContent = details;
    }
    if(steps){
        stepInput.value = steps;
        stepValue.textContent = steps;
    }
    if(size){
        if(size === "512x960"){
            aspectRatioInput.value = "9/16";
        }
        if(size === "960x512"){
            aspectRatioInput.value = "16/9";
        }
        if(size === "512x512"){
            aspectRatioInput.value = "1/1";
        }
    }

}

export default reuseStyles;