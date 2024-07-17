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
import cookieChange from "../cookieChange";
import isLoggedIn from "./is-logged-in";
import lastUserTask from "./last-user-task";
// import saveFaceToUser from "./save-face-to-user";
import addNewFaceToUI from "../add-new-face-to-ui";
import checkIfPremium from "../check-if-premium";
import deleteFace from "../delete-face";
import creditsLeft from "../credits/credits-left";
import useCredits from "../credits/use-credits";
import apiPing from "./api-ping";
import backCredits from "../credits/back-credits";
import saveFaceWithImage from "./save-face-with-image";

if(window.location.search) {
    reuseStyles();
}

let premiumBody = false;
if(document.querySelector('body').classList.contains('premium')){
    premiumBody = true;
} else {
    premiumBody = false;
}


const apiTasks = async () => {
    const serverStatus = await apiPing(premiumBody);
    let stopGenerateFlag = false;
    const form = document.querySelector('.creation-form');
    let isUpscaleInProgress = false;
    let taskID = "";

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
        document.querySelector('.user-faces').textContent = "Saved faces";
        form.reset();
    });


    const userLoggedIn = await isLoggedIn();

    if (checkIfPremium()) {
        const promptInput = document.querySelector('textarea[name="prompt"]');
        promptInput.addEventListener('blur', async (e) => {
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
           document.querySelector('.saveface').disabled = false;
           document.querySelector('.saveface').textContent = "Save face";
           switchGenerateButton(e.target, 'start');
           setPercent('0');
           if(!userLoggedIn) {
               if(!getCookie('freeGenerationUsed')) {
                   console.log('Leidziam Generuoti');
                   setCookie('freeGenerationUsed', 1, 365);

                   setPercent('1');
                   stopGenerateFlag = false;
                   if (generateAlreadyClicked) {
                       if (premiumBody) {
                           if (match && document.querySelector('#seed').checked) {
                               seed = match ? match[1] : null;
                           } else if (match && !document.querySelector('#seed').checked) {
                               seed = "-1";
                           } else if (!match && document.querySelector('#seed').checked) {
                               seed = lastSeed;
                           } else if (!match && !document.querySelector('#seed').checked) {
                               seed = "-1";
                           } else if (!match && !document.querySelector('#seed')) {
                               seed = "-1";
                           }
                       } else {
                           seed = "-1";
                       }
                   } else {
                       if (match && !document.querySelector('#seed').checked) {
                           seed = match ? match[1] : null;
                       } else if (match === null) {
                           seed = "-1";
                       } else {
                           seed = "-1";
                       }
                   }
                   generateAlreadyClicked = true;

                   const taskInfo = await apiSendTask(premiumBody, seed);
                   taskID = taskInfo.task_id;
                   console.log(taskID);
                   setCookie('lastGeneratedId', taskID, 1);
                   if (taskID === undefined) {
                       setCookie('lastGeneratedId', '', 1);
                       switchGenerateButton(e.target, 'error');
                       setPercent('Error');
                       const fullQueue = document.querySelector('#premium-queue');
                       fullQueue.textContent = "Please try again.";
                       return;
                   }

                   const postID = await addTaskToUser(taskID);
                   const userStatus = checkIfPremium();
                   let aspectRatio = "9/16"
                   if (document.querySelector('input[name="aspect-ratio"]')) {
                       aspectRatio = document.querySelector('input[name="aspect-ratio"]:checked').value;
                   }
                   setPercent('5');
                   let apiGetQueueInfo = await apiGetQueue(userStatus);
                   let currentTaskID = apiGetQueueInfo.currentTaskId;

                   if (currentTaskID !== taskID) {
                       setPercent('16');
                       if (userStatus) {
                           if (!stopGenerateFlag) {
                               setPercent('33');
                               let status = await showQueueInfo(taskID, userStatus);
                               while (status !== "done") {
                                   if (!stopGenerateFlag) {
                                       setPercent('66');
                                       apiGetQueueInfo = await apiGetQueue(userStatus);
                                       const currentPos = await getPosition(taskID, userStatus);
                                       await updateQueueInfo(currentPos.pos, '');
                                       status = await showQueueInfo(taskID, userStatus);
                                       if (status)
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
                               let currentTaskID = apiGetQueueInfo.currentTaskId;
                               while (currentTaskID !== taskID) {
                                   if (!stopGenerateFlag) {
                                       setPercent('premium');
                                       apiGetQueueInfo = await apiGetQueue(userStatus);
                                       const currentPos = await getPosition(taskID, userStatus);
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
                               if (!stopGenerateFlag) {
                                   let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                               }

                           }

                           if (!stopGenerateFlag) {
                               let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                               while (status !== "done") {
                                   if (!stopGenerateFlag) {
                                       status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                                       setPercent('66');
                                       apiGetQueueInfo = await apiGetQueue(userStatus);
                                       const currentPos = await getPosition(taskID, userStatus);
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

                       if (!stopGenerateFlag) {
                           let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                           setPercent('66');
                           while (status !== "done") {
                               if (!stopGenerateFlag) {
                                   setPercent('66');
                                   apiGetQueueInfo = await apiGetQueue(userStatus);
                                   if (apiGetQueueInfo) {
                                       const currentPos = await getPosition(taskID, userStatus);
                                       await updateQueueInfo(currentPos.pos, '');
                                       status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                                       if (stopGenerateFlag) {
                                           break;
                                       }
                                       await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                                   } else {
                                       stopGenerateFlag = true;
                                       break;
                                   }
                               } else {
                                   break;
                               }
                           }
                       }
                   }
                   if (!stopGenerateFlag) {

                       setPercent('99');
                       seed = await getSeed(taskID, userStatus);
                       const imgdata = await getImage(taskID, userStatus);
                       if (imgdata.image) {
                           let tempseed = imgdata.infotext;
                           const seedMatch = tempseed.match(/Seed: (\d+)/);
                           if (seedMatch) {
                               seed = seedMatch[1];
                               lastSeed = seed;
                               console.log('Done seed: ' + seed); // The extracted seed value as a string
                           }
                           document.querySelector('.saveface').dataset.id = taskID;
                           switchGenerateButton(document.querySelector('.generate'), 'end');
                           await loadImage(imgdata.image, userStatus, aspectRatio);
                           setPercent('100');
                           document.querySelector('.upscale').classList.remove('hidden');

                       } else {
                           setPercent('Error');
                       }
                   } else {
                       switchGenerateButton(e.target, 'stopped');
                       setCookie('lastGeneratedId', '', 1);
                       stopGenerateFlag = false;
                   }

                   //PABAIGA COOKIE CHECK GENERATION
               } else {
                   console.log('Neleidziam generuoti');
                   switchGenerateButton(e.target, 'stopped');
                   document.querySelector('.login-modal').classList.add('show');
                   document.querySelector('html').classList.add('modal-is-open');
               }

           } else {
               const userCredits = await creditsLeft();
               const lastUserTaskStatus = await lastUserTask(premiumBody);
               console.log(lastUserTaskStatus);
               if(lastUserTaskStatus.status === "Task is pending"){
                   //switchGenerateButton(e.target, 'start');
                    const alreadyGenerationID = lastUserTaskStatus.taskID;
                    if(lastUserTaskStatus.taskID !== "") {
                        console.log(alreadyGenerationID);
                        switchGenerateButton(e.target, 'already-generating');
                        stopGenerateFlag = false;
                        generateAlreadyClicked = true;

                        if (alreadyGenerationID === undefined) {
                            setCookie('lastGeneratedId', '', 1);
                            switchGenerateButton(e.target, 'error');
                            setPercent('Error');
                            const fullQueue = document.querySelector('#premium-queue');
                            fullQueue.textContent = "Please try again.";
                            return;
                        }


                        let apiGetQueueInfo = await apiGetQueue(premiumBody);
                        let currentTaskID = apiGetQueueInfo.currentTaskId;
                        if (currentTaskID !== alreadyGenerationID) {
                            setPercent('16');
                            if (premiumBody) {
                                if (!stopGenerateFlag) {
                                    setPercent('33');
                                    let status = await showQueueInfo(alreadyGenerationID, premiumBody);
                                    while (status !== "done") {
                                        if (!stopGenerateFlag) {
                                            setPercent('66');
                                            console.log('66');
                                            apiGetQueueInfo = await apiGetQueue(premiumBody);
                                            const currentPos = await getPosition(alreadyGenerationID, premiumBody);
                                            await updateQueueInfo(currentPos.pos, '');
                                            status = await showQueueInfo(alreadyGenerationID, premiumBody);
                                            if (status)
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
                                    let currentTaskID = apiGetQueueInfo.currentTaskId;
                                    while (currentTaskID !== alreadyGenerationID) {
                                        if (!stopGenerateFlag) {
                                            setPercent('premium');
                                            console.log('88');
                                            apiGetQueueInfo = await apiGetQueue(premiumBody);
                                            const currentPos = await getPosition(alreadyGenerationID, premiumBody);
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
                                    if (!stopGenerateFlag) {
                                        let status = await showQueueInfo(alreadyGenerationID, premiumBody); // Wait for the result of showQueueInfo
                                    }

                                }

                                if (!stopGenerateFlag) {
                                    let status = await showQueueInfo(alreadyGenerationID, premiumBody); // Wait for the result of showQueueInfo
                                    while (status !== "done") {
                                        if (!stopGenerateFlag) {
                                            status = await showQueueInfo(alreadyGenerationID, premiumBody); // Retry until status is "done"
                                            setPercent('66');
                                            console.log('99');
                                            apiGetQueueInfo = await apiGetQueue(premiumBody);
                                            const currentPos = await getPosition(alreadyGenerationID, premiumBody);
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

                            if (!stopGenerateFlag) {
                                let status = await showQueueInfo(alreadyGenerationID, premiumBody); // Wait for the result of showQueueInfo
                                setPercent('66');
                                while (status !== "done") {
                                    if (!stopGenerateFlag) {
                                        setPercent('66');
                                        console.log('987');
                                        apiGetQueueInfo = await apiGetQueue(premiumBody);
                                        if (apiGetQueueInfo) {
                                            const currentPos = await getPosition(alreadyGenerationID, premiumBody);
                                            await updateQueueInfo(currentPos.pos, '');
                                            status = await showQueueInfo(alreadyGenerationID, premiumBody); // Retry until status is "done"
                                            if (stopGenerateFlag) {
                                                break;
                                            }
                                            await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                                        } else {
                                            stopGenerateFlag = true;
                                            break;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                        if (!stopGenerateFlag) {
                            setPercent('99');
                            seed = await getSeed(alreadyGenerationID, premiumBody);
                            const imgdata = await getImage(alreadyGenerationID, premiumBody);
                            if (imgdata.image) {
                                let tempseed = imgdata.infotext;
                                const seedMatch = tempseed.match(/Seed: (\d+)/);
                                if (seedMatch) {
                                    seed = seedMatch[1];
                                    lastSeed = seed;
                                    console.log('Done seed: ' + seed); // The extracted seed value as a string
                                }
                                document.querySelector('.saveface').dataset.id = alreadyGenerationID;
                                switchGenerateButton(document.querySelector('.generate'), 'end');
                                await loadImage(imgdata.image, premiumBody, '9/16');
                                //await createPost(postID, imgdata.image, imgdata.infotext, taskID, '9/16');
                                setPercent('100');
                                document.querySelector('.upscale').classList.remove('hidden');

                            } else {
                                setPercent('Error');
                            }
                        } else {
                            switchGenerateButton(e.target, 'stopped');
                            setCookie('lastGeneratedId', '', 1);
                            stopGenerateFlag = false;
                        }
                    }

                   //END ALREADY GENERATION
               } else {


                   if(serverStatus) {
                   console.log(userCredits);
                   if (userCredits >= 1) {
                       setPercent('1');
                       await useCredits();
                       stopGenerateFlag = false;
                       if (generateAlreadyClicked) {
                           if (premiumBody) {
                               if (match && document.querySelector('#seed').checked) {
                                   seed = match ? match[1] : null;
                               } else if (match && !document.querySelector('#seed').checked) {
                                   seed = "-1";
                               } else if (!match && document.querySelector('#seed').checked) {
                                   seed = lastSeed;
                               } else if (!match && !document.querySelector('#seed').checked) {
                                   seed = "-1";
                               } else if (!match && !document.querySelector('#seed')) {
                                   seed = "-1";
                               }
                           } else {
                               seed = "-1";
                           }
                       } else {
                           if (match && !document.querySelector('#seed').checked) {
                               seed = match ? match[1] : null;
                           } else if (match === null) {
                               seed = "-1";
                           } else {
                               seed = "-1";
                           }
                       }
                       generateAlreadyClicked = true;

                       const taskInfo = await apiSendTask(premiumBody, seed);
                       taskID = taskInfo.task_id;
                       console.log(taskID);
                       setCookie('lastGeneratedId', taskID, 1);
                       if (taskID === undefined) {
                           setCookie('lastGeneratedId', '', 1);
                           switchGenerateButton(e.target, 'error');
                           setPercent('Error');
                           const fullQueue = document.querySelector('#premium-queue');
                           fullQueue.textContent = "Please try again.";
                           return;
                       }



                       const postID = await addTaskToUser(taskID);
                       const userStatus = checkIfPremium();
                       let aspectRatio = "9/16"
                       if (document.querySelector('input[name="aspect-ratio"]')) {
                           aspectRatio = document.querySelector('input[name="aspect-ratio"]:checked').value;
                       }
                       setPercent('5');
                       let apiGetQueueInfo = await apiGetQueue(userStatus);
                       let currentTaskID = apiGetQueueInfo.currentTaskId;

                       if (currentTaskID !== taskID) {
                           setPercent('16');
                           if (userStatus) {
                               if (!stopGenerateFlag) {
                                   setPercent('33');
                                   let status = await showQueueInfo(taskID, userStatus);
                                   while (status !== "done") {
                                       if (!stopGenerateFlag) {
                                           setPercent('66');
                                           console.log('33a');
                                           apiGetQueueInfo = await apiGetQueue(userStatus);
                                           const currentPos = await getPosition(taskID, userStatus);
                                           await updateQueueInfo(currentPos.pos, '');
                                           status = await showQueueInfo(taskID, userStatus);
                                           if (status)
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
                                   let currentTaskID = apiGetQueueInfo.currentTaskId;
                                   console.log('currentTaskId',currentTaskID);
                                   console.log('tavo task id', taskID);
                                   while (currentTaskID !== taskID) {
                                       if (!stopGenerateFlag) {
                                           console.log('33b');
                                           setPercent('premium');
                                           apiGetQueueInfo = await apiGetQueue(userStatus);
                                           const currentPos = await getPosition(taskID, userStatus);
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
                                   if (!stopGenerateFlag) {
                                       let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                                   }

                               }

                               if (!stopGenerateFlag) {
                                   let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                                   while (status !== "done") {
                                       if (!stopGenerateFlag) {
                                           status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                                           setPercent('66');
                                           console.log('33c');
                                           apiGetQueueInfo = await apiGetQueue(userStatus);
                                           const currentPos = await getPosition(taskID, userStatus);
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

                           if (!stopGenerateFlag) {
                               let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                               setPercent('66');
                               while (status !== "done") {
                                   if (!stopGenerateFlag) {
                                       setPercent('66');
                                       console.log('33d');
                                       apiGetQueueInfo = await apiGetQueue(userStatus);
                                       if (apiGetQueueInfo) {
                                           const currentPos = await getPosition(taskID, userStatus);
                                           await updateQueueInfo(currentPos.pos, '');
                                           status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                                           if (stopGenerateFlag) {
                                               break;
                                           }
                                           await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                                       } else {
                                           stopGenerateFlag = true;
                                           break;
                                       }
                                   } else {
                                       break;
                                   }
                               }
                           }
                       }
                       if (!stopGenerateFlag) {

                           setPercent('99');
                           seed = await getSeed(taskID, userStatus);
                           const imgdata = await getImage(taskID, userStatus);
                           if (imgdata.image) {
                               let tempseed = imgdata.infotext;
                               const seedMatch = tempseed.match(/Seed: (\d+)/);
                               if (seedMatch) {
                                   seed = seedMatch[1];
                                   lastSeed = seed;
                                   console.log('Done seed: ' + seed); // The extracted seed value as a string
                               }
                               document.querySelector('.saveface').dataset.id = taskID;
                               switchGenerateButton(document.querySelector('.generate'), 'end');
                               await loadImage(imgdata.image, userStatus, aspectRatio);
                               setPercent('100');
                               document.querySelector('.upscale').classList.remove('hidden');

                           } else {
                               setPercent('Error');
                           }
                       } else {
                           switchGenerateButton(e.target, 'stopped');
                           setCookie('lastGeneratedId', '', 1);
                           stopGenerateFlag = false;
                       }
                   } else {
                       switchGenerateButton(e.target, 'stopped');
                       document.querySelector('.credits-modal').classList.add('show');
                   }
               } else {
                       switchGenerateButton(e.target, 'stopped');
                       document.querySelector('.server-status').classList.add('show');
                   }
               }
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
        await stopGenerating(taskID, premiumBody);
        if(serverStatus) {
            await backCredits();
        }
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

    document.querySelector('.saveface').addEventListener('click', async (e1) => {
        e1.preventDefault();
        if (premiumBody) {
            const buttonElement = e1.currentTarget;
            const postid = await saveFaceWithImage();
            await addNewFaceToUI(postid);
            // await saveFaceToUser(faceTaskId);


            buttonElement.disabled = true;
            buttonElement.textContent = "Saved";
        } else {
            const modal = document.querySelector('.premium-modal');
            modal.classList.add('show');
        }
    });





};

export default apiTasks;