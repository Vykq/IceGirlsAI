import apiSendTask from "./api-send-task";
import apiGetQueue from "./api-get-queue";
import showQueueInfo from "./show-queue-info";
import getSeed from "./get-seed";
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
import addTaskToUser from "./add-task-to-user";
import checkPrompt from "./check-prompt";
import reuseStyles from "./reuse-styles";
import setCookie from "../createCookie";
import checkIfCookieSet from "../checkIfCookieSet";
import getCookie from "../getCookie";
import getCookieValue from "../getCookieValue";
import stopGenerating from "./stop-generating";

if(window.location.search) {
    reuseStyles();
}
const apiTasks = async () => {
    let premiumBody = false;
    if(document.querySelector('body').classList.contains('premium')){
        premiumBody = true;
    } else {
        premiumBody = false;
    }
    checkIfCookieSet(premiumBody);
    const form = document.querySelector('.creation-form');
    let isUpscaleInProgress = false;
    let taskID = "";
    let stopGenerateFlag = false;
    let seed = "";
    let lastSeed = '';
    let generateAlreadyClicked = false;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
    })


    form.querySelector('.clear').addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.choose-model').textContent = "Style";
        document.querySelector('.choose-scene').textContent = "Action";
        document.querySelector('.choose-char').textContent = "Characters";
        form.reset();
    });




    if (premiumBody) {
        const promptInput = document.querySelector('textarea[name="prompt"]');


        promptInput.addEventListener('blur', async (e) => {
            console.log('test');
            const wordArray = []; // Create an empty array to store the words
            const promptValue = promptInput.value;
            const words = promptValue.split(/[,\s]+/);
            wordArray.push(...words);
            const goodPrompt = await checkPrompt(wordArray);
            console.log(goodPrompt)
            if(goodPrompt.response === false){
                document.querySelector('.generate').disabled = true;
                document.querySelector('.error-notify').classList.add('show');
                document.querySelector('#keyword').textContent = goodPrompt.matchingWords;
                setTimeout(function() {
                    document.querySelector('.error-notify').classList.remove('show');
                }, 1000);
            } else {
                document.querySelector('.generate').disabled = false;
            }

        });
    }


        const currentURL = window.location.href;
        const match = currentURL.match(/[?&]seed=([^&]+)/);


    document.querySelector('.gen-bottom').addEventListener('click', (e) => {
        document.querySelector('header').scrollIntoView({ behavior: 'smooth' });
    });


    document.querySelectorAll('.generate').forEach(btn =>{
       btn.addEventListener('click', async (e) => {
            e.preventDefault();


            if(generateAlreadyClicked){
                if (premiumBody) {
                    if (match && document.querySelector('#seed').checked) {
                        seed = match ? match[1] : null;
                    } else if (match && !document.querySelector('#seed').checked) {
                        seed = "-1";
                    } else if (!match && document.querySelector('#seed').checked) {
                        seed = lastSeed;
                    } else if (!match && !document.querySelector('#seed').checked) {
                        seed = "-1";
                    } else if(!match && !document.querySelector('#seed')){
                        seed = "-1";
                    }
                } else {
                    seed = "-1";
                }
            } else {
                if (match && !document.querySelector('#seed').checked){
                    seed = match ? match[1] : null;
                } else if (match === null){
                    seed = "-1";
                } else {
                    seed = "-1";
                }
            }
            generateAlreadyClicked = true;
            console.log(generateAlreadyClicked);
            switchGenerateButton(e.target, 'start');
            console.log('naujas seed' + seed);
            const taskInfo = await apiSendTask(premiumBody, seed);
            taskID = taskInfo.task_id;
            console.log(taskID);
            setCookie('lastGeneratedId', taskID,1);
            if(taskID === undefined){
                setCookie('lastGeneratedId', '',1);
                switchGenerateButton(e.target, 'error');
                setPercent('Error');
                const fullQueue = document.querySelector('#premium-queue');
                fullQueue.textContent = "Please try again.";
                return;
            }


            setPercent('0');
            const postID = await addTaskToUser(taskID, taskInfo.raw);

            const userStatus = await isPremium(taskID);        //userStatus = true -- Premium user Premium taskID pridedam i duombaze
            let aspectRatio = "9/16"
            if(document.querySelector('input[name="aspect-ratio"]')){
                aspectRatio = document.querySelector('input[name="aspect-ratio"]:checked').value;
            }

            setPercent('5');



            let apiGetQueueInfo = await apiGetQueue(userStatus);
            let currentTaskID = apiGetQueueInfo.currentTaskId;
            let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
            //console.log('total tasks:' + totalPendingTasksObj)
            let queueTasks = apiGetQueueInfo.taskObjects;

            if (currentTaskID !== taskID) {
                setPercent('16');
                if (userStatus) {
                    if(!stopGenerateFlag) {
                        //const pendingTaskIds = totalPendingTasksObj.map(task => task.id);
                        //const positionToInsert = await checkTasks(pendingTaskIds, taskID);
                        console.log('new111');
                        //const moveOverID = pendingTaskIds[positionToInsert];
                        //await moveQueue(taskID, moveOverID, userStatus);
                        setPercent('33');
                        let status = await showQueueInfo(taskID, userStatus);
                        while (status !== "done") {
                            if(!stopGenerateFlag) {
                                setPercent('66');
                                apiGetQueueInfo = await apiGetQueue(userStatus);
                                const currentPos = await getPosition(taskID, userStatus);
                                let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                                const totalPendingTasksCount = totalPendingTasksObj.length;
                                await updateQueueInfo(currentPos.pos, '');
                                status = await showQueueInfo(taskID, userStatus);
                                if(status)
                                if (stopGenerateFlag) {
                                    break;
                                }
                                await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                            } else {
                                break;
                            }
                        }
                    }

                } else {
                    if (!stopGenerateFlag) {
                        setPercent('33');
                        const randomizer = Math.floor(Math.random() * 2);
                        if(randomizer === 1){
                            console.log('s');
                            // const pendingTaskIds = totalPendingTasksObj.map(task => task.id);
                            // const positionToInsert = await checkTasks(pendingTaskIds, taskID);
                            // const moveOverID = pendingTaskIds[positionToInsert];
                            // await moveQueue(taskID, moveOverID, userStatus);
                        }
                        let currentTaskID = apiGetQueueInfo.currentTaskId;
                        while (currentTaskID !== taskID) {
                            if(!stopGenerateFlag) {
                                setPercent('premium');
                                apiGetQueueInfo = await apiGetQueue(userStatus);
                                const currentPos = await getPosition(taskID,userStatus);
                                let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                                const totalPendingTasksCount = totalPendingTasksObj.length;
                                updateQueueInfo(currentPos.pos, '');
                                currentTaskID = apiGetQueueInfo.currentTaskId;
                                if (taskID === "" || stopGenerateFlag) {
                                    break;
                                }
                                await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                            } else {
                                break;
                            }
                        }
                        if(!stopGenerateFlag){
                            let status = await showQueueInfo(taskID,userStatus); // Wait for the result of showQueueInfo
                        }

                    }

                    if (!stopGenerateFlag) {
                        let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                        while (status !== "done") {
                            if(!stopGenerateFlag) {
                                status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                                setPercent('66');
                                apiGetQueueInfo = await apiGetQueue(userStatus);
                                const currentPos = await getPosition(taskID, userStatus);

                                let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                                const totalPendingTasksCount = totalPendingTasksObj.length;
                                await updateQueueInfo(currentPos.pos, '');
                                if (stopGenerateFlag) {
                                    break;
                                }
                                await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                            } else {
                                break;
                            }
                        }
                        setPercent('66');
                    }
                }

            } else {

                if(!stopGenerateFlag) {
                    let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                    seed = await getSeed(taskID, userStatus);
                    setPercent('66');
                    while (status !== "done") {
                        if(!stopGenerateFlag) {
                            setPercent('66');
                            apiGetQueueInfo = await apiGetQueue(userStatus);
                            const currentPos = await getPosition(taskID, userStatus);

                            let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                            const totalPendingTasksCount = totalPendingTasksObj.length;
                            await updateQueueInfo(currentPos.pos, '');
                            status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                            seed = await getSeed(taskID, userStatus);
                            if (stopGenerateFlag) {
                                break;
                            }
                            await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                        } else {
                            break;
                        }
                    }
                }
            }
            if(!stopGenerateFlag) {
                setPercent('99');
                const imgdata = await getImage(taskID, userStatus);
                if (imgdata.image) {
                    let tempseed = imgdata.infotext;
                    const seedMatch = tempseed.match(/Seed: (\d+)/);

                    if (seedMatch) {
                        seed = seedMatch[1];
                        lastSeed = seed;
                        console.log('Done seed: ' + seed); // The extracted seed value as a string
                    }
                    switchGenerateButton(document.querySelector('.generate'), 'end');
                    await loadImage(imgdata.image, userStatus, aspectRatio);
                    await createPost(postID, imgdata.image, imgdata.infotext, taskID, aspectRatio);
                    setPercent('100');
                    document.querySelector('.upscale').classList.remove('hidden');

                } else {
                    setPercent('Error');
                }
            } else {
                switchGenerateButton(e.target, 'stopped');
                setCookie('lastGeneratedId', '',1);
                stopGenerateFlag = false;
            }
        });
    });


        if(document.querySelector('#seed')) {
            document.querySelector('#seed').addEventListener('input', async (e) => {
                if (document.querySelector('#seed').checked) {
                    seed = lastSeed;
                } else {
                    seed = '';
                }
            });
        }



    document.querySelector('.stop-generate').addEventListener('click', async(ev) =>{
        ev.preventDefault();
        ev.disabled = true;
        stopGenerateFlag = true;
        stopGenerating(taskID, premiumBody);
    })

    document.querySelector('.stop-generate').addEventListener('dblclick', async(ev) =>{
        ev.preventDefault();
    })

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