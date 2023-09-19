const updateQueueInfo = (pos, all, next) => {
    const posElem = document.querySelector('#yourpos');
    const posAllElem = document.querySelector('#position-all');
    const fullQueue = document.querySelector('#premium-queue');

    if(next == ""){
        posElem.textContent = +pos + 1;
        posAllElem.textContent = all;
    } else {
        posElem.textContent = '';
        posAllElem.textContent = '';
        fullQueue.textContent = next;
    }


}

export default updateQueueInfo;