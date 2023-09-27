const updateQueueInfo = (pos, next) => {
    const fullQueue = document.querySelector('#premium-queue');
    const yourPos = +pos;
    if(next === ""){
        fullQueue.textContent = "Queue: " + yourPos;
    } else {
        fullQueue.textContent = next;
    }


}

export default updateQueueInfo;