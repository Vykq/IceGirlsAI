import apiSendTask from "./api-send-task";
import apiGetQueue from "./api-get-queue";
import showQueueInfo from "./show-queue-info";
import getImage from "./get-image";
import loadImage from "./load-image";
import getPosition from "./get-position";
import updateQueueInfo from "./update-queue-info";
import isPremium from "./is-premium";
import runPremium from "./run-premium";
import checkTasks from "./check-tasks";
import moveQueue from "./move-queue";
import createPost from "./create-post";
import switchGenerateButton from "./switch-generate-button";
import deleteIdFromQueue from "./delete-id-from-queue";
import setPercent from "./set-percent";
import getPercent from "./get-percent";
import upscaleImage from "./upscale-image";
const apiTasks = () => {
    const form = document.querySelector('.creation-form');
    let isUpscaleInProgress = false;

    let stopped = false;
    form.querySelector('.clear').addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.choose-model').textContent = "Model";
        document.querySelector('.choose-scene').textContent = "Action";
        form.reset();
    });



    let premiumBody = false;
    if(document.querySelector('body').classList.contains('premium')){
        premiumBody = true;
    } else {
        premiumBody = false;
    }

    document.querySelector('.generate').addEventListener('click', async (e) => {

        e.preventDefault();
        switchGenerateButton(e.target, 'start');

        const taskID = await apiSendTask(premiumBody);
        setPercent('0');
        const userStatus = await isPremium(taskID);        //userStatus = true -- Premium user Premium taskID pridedam i duombaze
        let aspectRatio = "9/16"
        if(document.querySelector('input[name="aspect-ratio"]')){
            aspectRatio = document.querySelector('input[name="aspect-ratio"]:checked').value;
        }

        setPercent('5');
        document.querySelector('.stop-generate').addEventListener('click', async(ev) =>{
            ev.preventDefault();
            let stopped = await deleteIdFromQueue(taskID);
            setPercent('');
            switchGenerateButton(e.target, 'stopped');

        })


            let apiGetQueueInfo = await apiGetQueue(userStatus);
            let currentTaskID = apiGetQueueInfo.currentTaskId;
            let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
            let queueTasks = apiGetQueueInfo.taskObjects;
            //console.log(queueTasks);
            //console.log(taskID);
            if (currentTaskID !== taskID) {
                setPercent('16');
                if (userStatus) {
                    const pendingTaskIds = totalPendingTasksObj.map(task => task.id);
                    const positionToInsert = await checkTasks(pendingTaskIds, taskID);
                    const moveOverID = pendingTaskIds[positionToInsert];
                    await moveQueue(taskID, moveOverID);
                    let status = await showQueueInfo(taskID);
                    setPercent('33');
                    while (status !== "done") {
                        setPercent('66');
                        apiGetQueueInfo = await apiGetQueue();
                        const currentPos = await getPosition(taskID);
                        let status = await showQueueInfo(taskID);
                        let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                        //console.log(totalPendingTasksObj)
                        const totalPendingTasksCount = totalPendingTasksObj.length;
                        updateQueueInfo(currentPos.pos, totalPendingTasksCount, '');
                        await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                    }

                } else {
                    setPercent('33');
                    while (currentTaskID !== taskID) {
                        setPercent('66');
                        apiGetQueueInfo = await apiGetQueue();
                        const currentPos = await getPosition(taskID);
                        let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                        const totalPendingTasksCount = totalPendingTasksObj.length;
                        updateQueueInfo(currentPos.pos, totalPendingTasksCount, '');
                        currentTaskID = apiGetQueueInfo.currentTaskId;
                        await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                    }
                    let status = await showQueueInfo(taskID); // Wait for the result of showQueueInfo
                    while (status !== "done") {
                        setPercent('68');
                        apiGetQueueInfo = await apiGetQueue();
                        const currentPos = await getPosition(taskID);
                        let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                        const totalPendingTasksCount = totalPendingTasksObj.length;
                        await updateQueueInfo(currentPos.pos, totalPendingTasksCount, '');
                        status = await showQueueInfo(taskID); // Retry until status is "done"
                        await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                    }
                    setPercent('66');
                }

            } else {
                let status = await showQueueInfo(taskID); // Wait for the result of showQueueInfo
                setPercent('66');
                while (status !== "done") {
                    const currentPos = await getPosition(taskID);
                    let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                    const totalPendingTasksCount = totalPendingTasksObj.length;
                    await updateQueueInfo(currentPos.pos, totalPendingTasksCount, '');
                    status = await showQueueInfo(taskID); // Retry until status is "done"
                    await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                }
            }
        setPercent('99');
        const imgdata = await getImage(taskID);
        if(imgdata.image){
            switchGenerateButton(e.target, 'end');
            loadImage(imgdata.image, userStatus, aspectRatio);
            await createPost(imgdata.image, imgdata.infotext, taskID, aspectRatio);
            setPercent('100');
            document.querySelector('.upscale').classList.remove('hidden');

        } else {
            setPercent('Error');
        }
    });

    document.querySelector('.upscale').addEventListener('click', async (e1) => {
        e1.preventDefault();
        if (premiumBody && !isUpscaleInProgress) { // Check if upscale is not in progress
            isUpscaleInProgress = true; // Set upscale in progress
            switchGenerateButton(e1.target, 'upscale');
            const upscaledImage = await upscaleImage(premiumBody, document.querySelector('.generated-image').src);
            if (upscaledImage) {
                document.querySelector('.upscale').disabled = true;
                switchGenerateButton(e1.target, 'end-upscale');
            }
            isUpscaleInProgress = false; // Reset upscale status after completion
        } else {
            const modal = document.querySelector('.premium-modal');
            modal.classList.add('show');
        }
    });
};

export default apiTasks;