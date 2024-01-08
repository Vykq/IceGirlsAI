const checkIfPremium = () => {
    const body = document.querySelector('body');

    if(body.classList.contains('premium')){
        return true;
    } else {
        return false;
    }

}

export default checkIfPremium;