const checkIfPremium = () => {
    const body = document.querySelector('body');
    const generateBtn = document.querySelector('button.generate');
    const stopBtn = document.querySelector('button.stop-generate');

    if(body.classList.contains('logged-in')){
        return true;
    } else {
        return false;
    }

}

export default checkIfPremium;