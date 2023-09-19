const setPercent = (percent) => {

    const text = document.querySelector('#steps-all');
    if(percent === "Error"){
        text.textContent = percent;
    } else {
        text.textContent = percent + "%";
    }


}

export default setPercent;