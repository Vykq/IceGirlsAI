import getCookie from "./getCookie";
import getCookieValue from "./getCookieValue";
import switchGenerateButton from "./api/switch-generate-button";
import showQueueInfo from "./api/show-queue-info";
import setCookie from "./createCookie";
import deleteIdFromQueue from "./api/delete-id-from-queue";
import setPercent from "./api/set-percent";
import apiGetQueue from "./api/api-get-queue";
import getPosition from "./api/get-position";
import updateQueueInfo from "./api/update-queue-info";
import getImage from "./api/get-image";
import loadImage from "./api/load-image";
import createPost from "./api/create-post";
import stopGenerating from "./api/stop-generating";
const checkIfCookieSet = async (premiumBody) => {


    const generateBtn = document.querySelector('.generate');
    const generateBtn2 = document.querySelector('.gen-bottom');
    let stopGenerateFlag = false;
    let taskID;
    let seed;
    let lastSeed;
    let status;



    let lastGeneratedId = getCookie("lastGeneratedId");
    alert(lastGeneratedId);
    if (lastGeneratedId === "") {
        generateBtn.disabled = false;
        generateBtn2.disabled = false;
        switchGenerateButton(document.querySelector('.generate'),'stopped');
    } else {
        taskID = getCookieValue('lastGeneratedId');
        document.querySelector('.stop-generate').addEventListener('click', async(ev) =>{
            ev.preventDefault();
            ev.disabled = true;
            stopGenerateFlag = true;
            stopGenerating(taskID, premiumBody);
        })
        console.log('daromas db' + taskID);
        switchGenerateButton(document.querySelector('.generate'),'start');
        status = await showQueueInfo(taskID, premiumBody);
        let apiGetQueueInfo = await apiGetQueue(premiumBody);
        let currentTaskID = apiGetQueueInfo.currentTaskId;
        let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
        //console.log('total tasks:' + totalPendingTasksObj)
        let queueTasks = apiGetQueueInfo.taskObjects;
        if(!stopGenerateFlag) {
        while (status !== "done") {
            if(!stopGenerateFlag) {
                setPercent('66');
                apiGetQueueInfo = await apiGetQueue(premiumBody);
                const currentPos = await getPosition(taskID, premiumBody);
                let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                const totalPendingTasksCount = totalPendingTasksObj.length;
                await updateQueueInfo(currentPos.pos, '');
                status = await showQueueInfo(taskID, premiumBody);
                if(!status){
                    switchGenerateButton(document.querySelector('.generate'),'stopped');
                    break;
                }
                if (stopGenerateFlag) {
                    break;
                }
                await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
            } else {
                break;
            }
        }
        } else {
            alert('kill here');
            return;
        }
        if(!stopGenerateFlag) {
            setPercent('99');
            const imgdata = await getImage(taskID, premiumBody);
            if (imgdata.image) {
                let tempseed = imgdata.infotext;
                const seedMatch = tempseed.match(/Seed: (\d+)/);

                if (seedMatch) {
                    seed = seedMatch[1];
                    lastSeed = seed;
                    console.log('Done seed: ' + seed); // The extracted seed value as a string
                }
                switchGenerateButton(document.querySelector('.generate'), 'end');
                await loadImage(imgdata.image, premiumBody, '9/16');
                await createPost(1, imgdata.image, imgdata.infotext, taskID, '9/16'); //todo: function to get postID by task id and aspect ratio
                setPercent('100');
                document.querySelector('.upscale').classList.remove('hidden');

            } else {
                setPercent('Error');
                setCookie('lastGeneratedId', '',1);
                stopGenerateFlag = true;
                return;
            }
        } else {
            switchGenerateButton(document.querySelector('.generate'), 'stopped');
            setCookie('lastGeneratedId', '',1);
            stopGenerateFlag = true;
            return;
        }
    }


}

export default checkIfCookieSet;