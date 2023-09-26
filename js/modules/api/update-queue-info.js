const updateQueueInfo = (pos, next) => {
    const posElem = document.querySelector('#yourpos');
    const fullQueue = document.querySelector('#premium-queue');

    if(next === ""){
        posElem.textContent = +pos + 1;
    } else {
        fullQueue.textContent = next;
    }


}

export default updateQueueInfo;